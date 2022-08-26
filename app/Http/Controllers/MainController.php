<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function model($model)
    {
        switch ($model) {
            case 'tiggo-2-pro':
                return view('models.tiggo-2');
            case 'tiggo-2-premium':
                return view('models.tiggo-2-premium');
            case 'new-tiggo-4-15':
                return view('models.tiggo-415');
            case 'new-tiggo-4-20':
                return view('models.tiggo-420');
            case 'tiggo-7-pro':
                return view('models.tiggo-7');
            default:
                return view('models.any');
        }
    }   
    public function tour($model)
    {
        switch ($model) {
            case 'tiggo-2-confort':
                return view('tour.tiggo-2confort');
            case 'tiggo-2-pro':
                return view('tour.tiggo-2');
            case 'tiggo-4-15-pro':
                return view('tour.tiggo-415');
            case 'tiggo-4-20-pro':
                return view('tour.tiggo-420');
            case 'tiggo-7-pro':
                return view('tour.tiggo-7');
            case 'show-room':
                return view('tour.showRoom');
            default:
                return view('tour.tiggo-2');
        }
    }
    public function chery()
    {
        return view('porqueChery');
    }
    public function experiencia()
    {
        # code...
        return view('experiencia');
    }
    public function experienciaBlog($blog)
    {
        switch ($blog) {
            case 'camara-escondida-a-carlos-marquina':
                return view('blogs.camara');
            case 'chery-bolivia-expocruz-2021':
                return view('blogs.expo');
            case 'chery-bolivia-en-la-feria-sobre-ruedas':
                return view('blogs.feria');
            default:
                return redirect(route('experiencia'));
        }
    }
    public function contacto()
    {
        # code...
        return view('contacto');
    }
    public function concesionarios()
    {
        # code...
        return view('concesionarios');
    }

    public function servicio()
    {
        # code...
        return view('servicio');
    }
}
