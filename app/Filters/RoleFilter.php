<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $role = $session->get('role') ?? 'Employee';
        $uri = (string) $request->getUri();
        $path = parse_url($uri, PHP_URL_PATH) ?? '';
        $map = [
            'api/salaries/calculate' => ['Admin','Finance'],
            'api/salaries/approve' => ['Admin','Finance'],
        ];
        foreach ($map as $key => $roles) {
            if (str_contains($path, $key) && !in_array($role, $roles, true)) {
                return service('response')->setStatusCode(403)->setJSON(['message' => 'Forbidden']);
            }
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
