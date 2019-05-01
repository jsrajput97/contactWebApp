<?php

namespace App\Http\Controllers;

use App\Contact;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class contactController extends Controller
{

    public function getDashboard()
    {
        $contacts = DB::table('contacts')->select('*')->where('user_id',Auth::user()->id)->orderby('name','asc')->get();
        //$contacts = Contact::all();
        return view('dashboard',['contacts' => $contacts]);
    }

    public function deleteContact($contact_id)
    {
        $contact = Contact::where([['id', $contact_id],['user_id',Auth::user()->id]])->first();
        if($contact==null)
        {
            return redirect()->route('home');
        }
        $contact->delete();
        return redirect()->route('dashboard')->with(['message' => 'Contact removed']);
    }

    public function createContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:23',
            'number' => 'required|min:10'
        ]);
        $cnumber = DB::select('select * from contacts where number = ? and user_id = ?', [$request['number'], Auth::user()->id]);

        //$cnumber = DB::table('contacts')->select('*')->where([['number',$request['number']],['user_id',Auth::user()->id]])->get();
        //Log::info(count($cnumber));


        if(count($cnumber) == 0)
        {

            $contact = new Contact();
            $contact->name = $request['name'];
            $contact->number = $request['number'];

            $message = 'There was an error';
            if($request->user()->contacts()->save($contact))
            {
                $message = 'Contact successfully saved!';
            }
            return redirect()->route('dashboard')->with(['message' => $message]);
        }
        else
        {
            $message = 'Number is already saved';
            return redirect()->route('dashboard')->with(['message' => $message]);
        }
    }

    public function updateContact(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'number' => 'required|min:10'
        ]);
        $cnumber = DB::select('select * from contacts where number = ? and user_id = ? and id != ?', [$request['number'], Auth::user()->id, $request['contactId']]);

        //$cnumber = DB::table('contacts')->select('*')->where([['number',$request['number']],['user_id',Auth::user()->id]])->get();
        //Log::info(count($cnumber));

        $notification = array(
            'message' => 'Number is already saved',
            'alert-type' => 'warning'
        );

        if(count($cnumber) == 0) {

            $contact = Contact::find($request['contactId']);
            if(Auth::user()->id != $contact->user_id)
            {
                return redirect()->back();
            }
            $contact->name = $request['name'];
            $contact->number = $request['number'];
            $contact->update();

            $notification['alert-type'] = 'success';
            $notification['message'] = 'Contact Successfully updated';
            return response()->json(['name' => $contact->name, 'number' => $contact->number, 'message' => $notification], 200);
        }

        return response()->json(['message' => $notification],200);
    }

    public function userContacts(){

        $selectcontacts = DB::table('contacts')->select('*')->where('user_id',Auth::user()->id)->orderby('name','asc')->get();
        if(count($selectcontacts) == 0)
        {
            return redirect()->back()->with('message','Contacts not found');
        }
        $contacts = "";
        foreach ($selectcontacts as $contact)
        {
            $contacts = $contacts . "BEGIN:VCARD\nVERSION:3.0\nFN:$contact->name\nTEL;TYPE=PREF:$contact->number\nEND:VCARD\n";
        }


        $contactFile = "contacts.vcf";
        file_put_contents($contactFile, $contacts);
        return response()->download($contactFile);
    }

    public function importContacts(Request $request)
    {
        $this->validate($request,[
           'importcontacts' => 'required|mimes:vcf,vcard'
        ]);


        $request->file('importcontacts')->move(public_path('contacts/import'),'contacts.vcf');

        $fn = 'FN:';
        $tel = 'TEL;TYPE=CELL;TYPE=PREF:';
        $tel1 = 'TEL;TYPE=PREF:';
        $end = 'END:VCARD';
        $contact = [];
        $i = 0;
        $count = 0;
        $nam = 0;
        $num = 0;
        $notvalid = 0;
        $already = 0;
        $added = 0;
        foreach (file('contacts/import/contacts.vcf') as $line)
        {
            if(substr($line, 0, strlen($fn)) === $fn)
            {
                $nam = 1;
                $name = str_replace($fn,"",$line);
                $contact['name'][$i] = $name;
            }
            if(substr($line, 0, strlen($tel)) === $tel || substr($line, 0, strlen($tel1)) === $tel1)
            {
                if(substr($line, 0, strlen($tel)) === $tel)
                {
                    $number = str_replace($tel,"",$line);
                }
                else
                {
                    $number = str_replace($tel1,"",$line);
                }

                $number = str_replace("-","",$number);
                $contact['number'][$i] = $number;
                $num = 1;
            }
            if (substr($line, 0, strlen($end)) === $end)
            {
                if($nam === 0)
                {
                    $contact['name'][$i] = "";
                }
                if ($num === 0)
                {
                    $contact['number'][$i] = "";
                }
                $i = $i + 1;
                $nam = 0;
                $num = 0;
            }
        }
        if(count($contact['name']) === count($contact['number']))
        {
            $count = count($contact['name']);
        }
        elseif(count($contact['name']) >= count($contact['number']))
        {
            $count = count($contact['name']);
        }
        else
        {
            $count = count($contact['number']);
        }

        for($j = 0; $j < $count; $j++)
        {
            //Log::info($contact['name'][$j]);
            //Log::info($contact['number'][$j]);

            if($contact['name'][$j] == "" || $contact['number'][$j] == "")
            {
                $notvalid = $notvalid + 1;
                continue;
            }
            if(strlen($contact['name'][$j]) > 23 || strlen($contact['number'][$j]) < 10)
            {
                $notvalid = $notvalid + 1;
                continue;
            }
            $user = Auth::user();
            $check = DB::select('select * from contacts where number = ? and user_id = ?', [$contact['number'][$j], $user->id]);
            if(count($check) > 0)
            {
                $already = $already + 1;
                continue;
            }
            $addcontact = new Contact();
            $addcontact->name = $contact['name'][$j];
            $addcontact->number = $contact['number'][$j];
            $user->contacts()->save($addcontact);

            $added = $added + 1;
        }
        $message = $added . ' new contact added, ' . $already . ' contact already found and ' . $notvalid . ' are not valid.';
        return redirect()->back()->with('message', $message);
    }

}
