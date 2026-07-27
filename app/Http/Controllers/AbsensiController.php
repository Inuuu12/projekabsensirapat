<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return 'Admin Agenda Index'; 
    }
    public function create()
    {
        return 'Return Agenda Create';
    }
    public function store(Request $request)
    {
        return 'Return Agenda Store';
    }
    public function show($id)
    {
        return 'Admin Agenda Show' . $id;
    }
    public function edit($id)
    {
        return 'Admin Agenda Edit' . $id;
    }
    public function update($id)
    {
        return 'Admin Agenda Update' . $id;
    }
    public function destroy($id)
    {
        return 'Admin Agenda Destroy ' . $id;
    }

    // Participants methods (linked to Agenda)
    public function participants($id)
    {
        return 'Admin Agenda Participants ' . $id;
    }

    public function storeParticipant(Request $request, $id)
    {
        return 'Admin Agenda Store Participant for Agenda ' . $id;
    }

    public function destroyParticipant($id, $participant_id)
    {
        return 'Admin Agenda Destroy Participant ' . $participant_id . ' from Agenda ' . $id;
    }
}
