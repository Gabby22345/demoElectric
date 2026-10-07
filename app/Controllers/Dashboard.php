<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Dashboard extends BaseController
{
    protected CustomerAccountModel $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    protected function requireLogin()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in to open the dashboard.');
        }
        return null;
    }

    protected function fields(): array
    {
        return [
            'account_number' => trim((string) $this->request->getPost('account_number')),
            'customer_name' => trim((string) $this->request->getPost('customer_name')),
            'address' => trim((string) $this->request->getPost('address')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => trim((string) $this->request->getPost('email')),
            'meter_number' => trim((string) $this->request->getPost('meter_number')),
            'connection_type' => (string) $this->request->getPost('connection_type'),
            'status' => (string) $this->request->getPost('status'),
        ];
    }

    protected function validateFields(array $data, ?int $id = null): array
    {
        $rules = [
            'account_number' => 'required|max_length[40]',
            'customer_name' => 'required|min_length[2]|max_length[150]',
            'address' => 'required|max_length[255]',
            'phone' => 'required|max_length[30]',
            'email' => 'required|valid_email|max_length[150]',
            'meter_number' => 'required|max_length[40]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status' => 'required|in_list[active,inactive,suspended]',
        ];

        $validation = service('validation');
        if (!$validation->setRules($rules)->run($data)) {
            return $validation->getErrors();
        }
        $duplicate = $this->customerModel->where('account_number', $data['account_number']);
        if ($id) {
            $duplicate->where('id !=', $id);
        }
        if ($duplicate->first()) {
            return ['account_number' => 'This account number is already in use.'];
        }
        return [];
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) return $redirect;

        $search = trim((string) $this->request->getGet('search')) ?: null;
        $status = $this->request->getGet('status') ?: null;
        $type = $this->request->getGet('type') ?: null;

        $statsModel = new CustomerAccountModel();
        return view('dashboard/index', [
            'title' => 'Dashboard - Puihaha Electric',
            'accounts' => $this->customerModel->filtered($search, $status, $type),
            'pager' => $this->customerModel->pager,
            'total_accounts' => $statsModel->countAll(),
            'active_accounts' => $statsModel->countByStatus('active'),
            'inactive_accounts' => $statsModel->countByStatus('inactive'),
            'suspended_accounts' => $statsModel->countByStatus('suspended'),
            'search_keyword' => $search,
            'filter_status' => $status,
            'filter_type' => $type,
        ]);
    }

    public function new()
    {
        if ($redirect = $this->requireLogin()) return $redirect;
        return view('dashboard/form', ['title' => 'New Account - Puihaha Electric', 'account' => [], 'errors' => []]);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) return $redirect;
        $data = $this->fields();
        $errors = $this->validateFields($data);
        if ($errors) return view('dashboard/form', ['title' => 'New Account - Puihaha Electric', 'account' => $data, 'errors' => $errors]);
        $this->customerModel->insert($data);
        return redirect()->to('/dashboard')->with('success', 'Customer account created successfully.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireLogin()) return $redirect;
        $account = $this->customerModel->find($id);
        if (!$account) return redirect()->to('/dashboard')->with('error', 'Account not found.');
        return view('dashboard/form', ['title' => 'Edit Account - Puihaha Electric', 'account' => $account, 'errors' => []]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireLogin()) return $redirect;
        $data = $this->fields();
        $errors = $this->validateFields($data, $id);
        if ($errors) return view('dashboard/form', ['title' => 'Edit Account - Puihaha Electric', 'account' => array_merge(['id' => $id], $data), 'errors' => $errors]);
        $this->customerModel->update($id, $data);
        return redirect()->to('/dashboard')->with('success', 'Customer account updated successfully.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireLogin()) return $redirect;
        $this->customerModel->delete($id);
        return redirect()->to('/dashboard')->with('success', 'Customer account deleted.');
    }
}
