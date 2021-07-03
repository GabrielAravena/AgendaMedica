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
            //dd($agendas);

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

    /* public function store(Request $request){

        $rules =[
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'service_hash' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors(), JSON_UNESCAPED_SLASHES);
            return response($errors, 400);
        }


        $serviceBooking = new ServiceBooking;

        $service = Service::where('hash', $request->service_hash)->first();

        $customer = Customer::where('email', $request->email)->first();
        if(!$customer){
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'uid' => '123456',
                'created_by_user_id' => $service->user_id,
            ]);
        }

        $formula = [
            'service_name' => $service->name,
            'service_duration' => $service->duration,
            'service_unit' => $service->unit,
            'service_currency_id' => $service->currency_id,
            'service_hash' => $service->hash,
            'service_user_id' => $service->user_id,
            'service_calendar_color' => $service->calendar_color,
            'customer_first_name' => $request->first_name,
            'customer_last_name' => $request->last_name,
            'customer_email' => $request->email,
        ];

        $start_at = $request->date." ".$request->start_time;
        $ends_at = $request->date." ".$request->end_time;
        
        $serviceBooking->make([
                'starts_at' => $start_at, 
                'ends_at' => $ends_at, 
                'price' => $service->price, 
                'quantity' => 1, 
                'currency' => $service->currency->code, 
                'formula' => $formula,
                'notes' => $request->comment,
            ])
            ->customer()->associate($customer)
            ->bookable()->associate($service)
            ->save();
    } */

    /* public function events($hash = ""){

        if($serviceBookings = Service::where('hash', $hash)->first()){
            $serviceBookings = $serviceBookings->getBookingModel()->where('canceled_at', null)->get();
        }else{
            $serviceBookings = ServiceBooking::where('canceled_at', null)->get();
        }
        
        $events = [];
        foreach($serviceBookings as $serviceBooking){
            $service = $serviceBooking->bookable;
            $customer = $serviceBooking->customer;
            $event = array(
                'title' => $service->name,
                'start' => $serviceBooking->starts_at,
                'end' => $serviceBooking->ends_at,
                'color' => $service->calendar_color,
                'customerFirstName' => $customer->first_name,
                'customerLastName' => $customer->last_name,
                'customerEmail' => $customer->email,
                'start_at' => $serviceBooking->starts_at,
                'ends_at' => $serviceBooking->ends_at,
                'comment' => $serviceBooking->notes,
            );
            array_push($events, $event);
        }
        $response = json_encode($events);
        return response($response, 200);
    } */
}
