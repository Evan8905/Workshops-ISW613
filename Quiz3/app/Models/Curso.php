<?php

namespace App\Models;

use CodeIgniter\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $allowedFields = ['nombre', 'codigo', 'creditos', 'carrera_id'];

    public function listarConCarrera(): array
    {
        return $this->select('cursos.*, carreras.nombre AS carrera')
            ->join('carreras', 'carreras.id = cursos.carrera_id')
            ->orderBy('cursos.nombre')
            ->findAll();
    }
}
