<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
            $session = session();
            $path = trim($request->getUri()->getPath(), '/');
            if (!$session->get('user_id')) {
                if (strpos($path, 'api/') === 0) {
                    return service('response')->setStatusCode(401)->setJSON(['message' => 'Unauthorized']);
                }
                return redirect()->to('/');
            }
            return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
