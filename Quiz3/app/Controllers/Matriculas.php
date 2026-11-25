<?php

namespace App\Controllers;

use App\Models\Curso;
use App\Models\Matricula;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;

class Matriculas extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        return $this->formulario();
    }

    public function guardar()
    {
        $datos = $this->request->getPost(['carne', 'curso_id']);
        foreach ($datos as &$valor) {
            $valor = is_string($valor) ? trim($valor) : '';
        }
        unset($valor);

        $reglas = [
            'carne' => [
                'rules' => 'required|max_length[30]',
                'errors' => [
                    'required' => 'Ingresa el carné del estudiante.',
                    'max_length' => 'El carné admite hasta 30 caracteres.',
                ],
            ],
            'curso_id' => [
                'rules' => 'required|is_natural_no_zero|is_not_unique[cursos.id]',
                'errors' => [
                    'required' => 'Selecciona un curso.',
                    'is_natural_no_zero' => 'Selecciona un curso válido.',
                    'is_not_unique' => 'El curso seleccionado ya no está disponible.',
                ],
            ],
        ];

        if (!$this->validateData($datos, $reglas)) {
            return $this->formulario($datos, $this->validator->getErrors());
        }

        try {
            $id = model(Matricula::class)->insert($datos);
        } catch (DatabaseException $error) {
            if ($error->getCode() !== 1452) {
                throw $error;
            }

            return $this->formulario($datos, ['El curso seleccionado ya no está disponible.']);
        }

        $sesion = session();
        $comprobantes = $sesion->get('comprobantes') ?? [];
        $comprobantes[] = (int) $id;
        $sesion->set('comprobantes', $comprobantes);

        return redirect()->to(site_url('matriculas/' . $id), 303)->withCookies();
    }

    public function comprobante(int $id): string
    {
        $ids = session()->get('comprobantes') ?? [];
        $matricula = in_array($id, $ids, true) ? model(Matricula::class)->buscarComprobante($id) : null;
        if ($matricula === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('matriculas/comprobante', ['matricula' => $matricula]);
    }

    private function formulario(array $datos = [], array $errores = []): string
    {
        if ($errores !== []) {
            $this->response->setStatusCode(422);
        }

        return view('matriculas/formulario', [
            'cursos' => model(Curso::class)->orderBy('nombre')->findAll(),
            'datos' => $datos,
            'errores' => $errores,
        ]);
    }
}
