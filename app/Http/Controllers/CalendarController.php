<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\User;
use App\Http\Requests\CalendarRequest;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\Horario;
use Illuminate\Support\Facades\Validator;


class CalendarController extends Controller
{
    public function index()
    {
        if($user = backpack_user()){
            $especialidades = Especialidad::all();
            $doctores = Doctor::where('especialidad_id', 1)->get();
            
            return view('calendar', compact('especialidades', 'doctores'));
        }else{
            return redirect(backpack_url('login'));
        }
    }

    public function getDoctors($id){
        $doctores = Doctor::where("especialidad_id", $id)->get();
        $response = ['data' => $doctores];

        return response()->json($response);
    }

    public function getEvents(){

        $user = backpack_user();

        if($user->hasRole('Admin') || $user->hasRole("Adminisitrador")){
            $agendas = Agenda::all();
        }else{
            $agendas = Agenda::where('user_id', $user->id)->where('fecha', '>=', date("y-m-d"))->get();
        }

        $events = [];
        foreach($agendas as $agenda){
            $horaTermino = date('H:i:s', strtotime('+30 minutes', strtotime($agenda->hora)));
            $event = array(
                'title' => $agenda->doctor->especialidad->nombre,
                'start' => $agenda->fecha. " " .$agenda->hora,
                'end' => $agenda->fecha. " " .$horaTermino,
                'doctor' => $agenda->doctor->nombre,
                'especialidad' => $agenda->doctor->especialidad->nombre,
                'fecha' => $agenda->fecha,
                'hora' => $agenda->hora,
                'agenda_id' => $agenda->id,
            );
            array_push($events, $event);
        }
        return response()->json($events);
    }

    public function getHorario($doctor_id){

        $user = backpack_user();

        $horarios = Horario::where('doctor_id', $doctor_id)->get();

        $businessHours = [];
        foreach($horarios as $horario){
            $businessHours[] = [
                'daysOfWeek' => [$horario->dia],
                'startTime' => $horario->desde, 
                'endTime' => $horario->hasta,
            ]; 
        }

        $events = [];
        if (!$user->hasRole('Admin') && !$user->hasRole('Administrador')) {
            $agendas = Agenda::where('user_id', "!=", $user->id)->where('doctor_id', $doctor_id)->get();

            foreach ($agendas as $agenda) {
                $horaTermino = date('H:i:s', strtotime('+30 minutes', strtotime($agenda->hora)));
                $event = array(
                    'title' => '',
                    'start' => $agenda->fecha . " " . $agenda->hora,
                    'end' => $agenda->fecha . " " . $horaTermino,
                    'color' => '#dcdcdc',
                    'textColor' => '#dcdcdc',
                    'display' => 'background',
                    'horaNoHabilitada' => 'horaNoHabilitada',
                );
                array_push($events, $event);
            }
        }
        
        $response = [];
        $response += ['businessHours' => $businessHours];
        $response += ['events' => $events];

        return response()->json($response);
    }

    public function store(Request $request){
        $rules =[
            'fecha' => 'required|date',
            'hora' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors(), JSON_UNESCAPED_SLASHES);
            return response($errors, 400);
        }

        $agenda = Agenda::create([
            'user_id' => backpack_user()->id,
            'doctor_id' => $request->doctor_id,
            'fecha' => date('Y-m-d', strtotime($request->fecha)),
            'hora' => $request->hora,
            'duracion' => Agenda::DURACION,
        ]);
    }

    public function delete(Request $request){

        $user = backpack_user();
        $agenda = Agenda::find($request->agenda_id);

        if($user->hasRole("Admin")){
            $agenda->delete();
        }else{
            if($agenda->user_id == $user->id){
                $agenda->delete();
            }
        }
        return response("ok", 200);
    }
}
