<?php

namespace App\Controllers;

use App\Models\Carrera;
use App\Models\Curso;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;

class Cursos extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        return view('cursos/lista', ['cursos' => model(Curso::class)->listarConCarrera()]);
    }

    public function nuevo(): string
    {
        return $this->formulario();
    }

    public function editar(int $id): string
    {
        return $this->formulario($this->buscar($id));
    }

    public function guardar(?int $id = null)
    {
        if ($id !== null) {
            $this->buscar($id);
        }

        $datos = $this->request->getPost(['nombre', 'codigo', 'creditos', 'carrera_id']);
        foreach ($datos as &$valor) {
            $valor = is_string($valor) ? trim($valor) : '';
        }
        unset($valor);

        $reglas = [
            'nombre' => ['label' => 'Nombre del curso', 'rules' => 'required|max_length[100]'],
            'codigo' => ['label' => 'Código del curso', 'rules' => 'required|max_length[20]'],
            'creditos' => [
                'label' => 'Cantidad de créditos',
                'rules' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[4294967295]',
                'errors' => [
                    'required' => 'Ingresa la cantidad de créditos.',
                    'integer' => 'Los créditos deben ser un número entero.',
                    'greater_than_equal_to' => 'Los créditos deben ser cero o más.',
                    'less_than_equal_to' => 'La cantidad de créditos supera el límite permitido.',
                ],
            ],
            'carrera_id' => ['label' => 'Carrera', 'rules' => 'required|is_natural_no_zero|is_not_unique[carreras.id]'],
        ];
        $reglas['nombre']['errors'] = [
            'required' => 'Ingresa el nombre del curso.',
            'max_length' => 'El nombre admite hasta 100 caracteres.',
        ];
        $reglas['codigo']['errors'] = [
            'required' => 'Ingresa el código del curso.',
            'max_length' => 'El código admite hasta 20 caracteres.',
        ];
        $reglas['carrera_id']['errors'] = [
            'required' => 'Selecciona una carrera.',
            'is_natural_no_zero' => 'Selecciona una carrera válida.',
            'is_not_unique' => 'Selecciona una carrera válida.',
        ];

        if (!$this->validateData($datos, $reglas)) {
            return $this->formulario($datos + ['id' => $id], $this->validator->getErrors());
        }

        try {
            $cursos = model(Curso::class);
            if ($id === null) {
                $cursos->insert($datos);
            } else {
                $cursos->update($id, $datos);
            }
        } catch (DatabaseException $error) {
            $mensaje = match ($error->getCode()) {
                1062 => 'Ya existe un curso con ese código.',
                1452 => 'Selecciona una carrera válida.',
                default => throw $error,
            };

            return $this->formulario($datos + ['id' => $id], [$mensaje]);
        }

        return $this->volver($id === null ? 'Curso creado.' : 'Curso actualizado.');
    }

    public function eliminar(int $id)
    {
        $this->buscar($id);

        try {
            model(Curso::class)->delete($id);
        } catch (DatabaseException $error) {
            if ($error->getCode() !== 1451) {
                throw $error;
            }

            return $this->volver('El curso tiene matrículas y no se puede eliminar.');
        }

        return $this->volver('Curso eliminado.');
    }

    private function buscar(int $id): array
    {
        $curso = model(Curso::class)->find($id);
        if ($curso === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $curso;
    }

    private function formulario(array $curso = [], array $errores = []): string
    {
        if ($errores !== []) {
            $this->response->setStatusCode(422);
        }

        return view('cursos/formulario', [
            'curso' => $curso,
            'carreras' => model(Carrera::class)->orderBy('nombre')->findAll(),
            'errores' => $errores,
        ]);
    }

    private function volver(string $mensaje)
    {
        return redirect()->to(site_url('cursos'), 303)->withCookies()->with('mensaje', $mensaje);
    }
}
