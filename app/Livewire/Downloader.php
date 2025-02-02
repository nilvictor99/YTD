<?php

namespace App\Livewire;

use Livewire\Component;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Downloader extends Component
{
    public $url;
    public $downloadType = 'video';

    public function download()
    {
        $this->validate([
            'url' => 'required|url',
            'downloadType' => 'required|in:video,audio'
        ]);

        // Determinar qué script usar
        $scriptName = $this->downloadType === 'video'
            ? 'Video.py'
            : 'Audio.py';

        // Ajustar ruta usando public_path()
        $scriptPath = public_path('scripts' . DIRECTORY_SEPARATOR . $scriptName);

        // Verificar si el archivo existe
        if (!file_exists($scriptPath)) {
            session()->flash('error', 'Error: El script de descarga no existe');
            return;
        }

        $process = new Process([
            'python',
            $scriptPath,
            $this->url
        ]);

        try {
            $process->setTimeout(300);  // 5 minutos de timeout
            $process->mustRun();

            $message = $this->downloadType === 'video'
                ? 'Video descargado exitosamente'
                : 'Audio descargado exitosamente';

            session()->flash('message', $message);
        } catch (ProcessFailedException $exception) {
            // Mejor manejo de errores incluyendo salida del script
            $errorOutput = $exception->getProcess()->getErrorOutput();

            $error = match (true) {
                str_contains($errorOutput, 'Unsupported URL') => 'URL no válida o no soportada',
                str_contains($errorOutput, 'FFmpeg') => 'Error al procesar el archivo: Verifica que FFmpeg esté instalado',
                str_contains($errorOutput, 'error:') => 'Error en la descarga: ' . explode('error:', $errorOutput)[1],
                default => 'Error desconocido: ' . $errorOutput
            };

            session()->flash('error', $error);
        }
    }

    public function render()
    {
        return view('livewire.downloader');
    }
}