<?php

namespace App\Models;

use CodeIgniter\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';
    protected $allowedFields = ['carne', 'curso_id'];

    public function buscarComprobante(int $id): ?array
    {
        return $this->select('matriculas.*, cursos.nombre AS curso, cursos.codigo, carreras.nombre AS carrera')
            ->join('cursos', 'cursos.id = matriculas.curso_id')
            ->join('carreras', 'carreras.id = cursos.carrera_id')
            ->find($id);
    }
}
