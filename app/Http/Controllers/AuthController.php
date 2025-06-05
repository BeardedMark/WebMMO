<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Главная страница
    public function main()
    {
        return view('db.users.main');
    }

    // Форма авторизации
    public function login()
    {
        return view('db.users.login');
    }

    // Авторизация
    public function authorization(Request $request)
    {
        $validatedData = $request->validate([
            'login' => 'required|string|min:4|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'login.required' => 'Поле "Наименование" обязательно для заполнения',
            'login.min' => 'Поле "Наименование" должно содержать не менее :min символов',
            'login.max' => 'Поле "Наименование" не должно превышать :max символов',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Пароль должен содержать не менее :min символов',
            'password.regex' => 'Пароль должен содержать минимум 1 заглавную букву и 1 цифру',
        ]);

        $user = User::where('login',  $validatedData['login'])
            ->orWhere('email',  $validatedData['login'])
            ->first();

        if (!$user) {
            return back()->withErrors('Неверный логин или адрес электронной почты');
        }

        if (
            Auth::attempt(['login' => $user->login, 'password' => $validatedData['password']]) ||
            Auth::attempt(['email' => $user->email, 'password' => $validatedData['password']])
        ) {
            return redirect()->route('users.main', $user);
        }

        return back()->withErrors('Неверный пароль');
    }

    // Выход пользователя
    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.login');
    }

    // Форма регистрации
    public function register()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {

            return view('db.users.register');
        } else {
            return view('db.users.offer');
        }
    }

    // Регистрация
    public function registration(Request $request)
    {
        $validatedData = $request->validate([
            'login' => 'required|string|min:4|unique:users,login|max:255',
            'email' => 'required|string|email|unique:users,email|max:255|regex:/^[a-zA-Z0-9._-]+@+[a-zA-Z0-9.-]+\.[a-zA-Z]{2,9}$/',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'login.required' => 'Поле "Наименование" обязательно для заполнения',
            'login.unique' => 'Такое "Наименование" уже существует',
            'login.min' => 'Поле "Наименование" должно содержать не менее :min символов',
            'login.max' => 'Поле "Наименование" не должно превышать :max символов',
            'email.required' => 'Поле "Почта" обязательно для заполнения',
            'email.email' => 'Поле "Почта" должно быть корректным адресом электронной почты',
            'email.unique' => 'Такая "Почта" уже используется',
            'email.max' => 'Поле "Почта" не должно превышать :max символов',
            'email.regex' => 'Поле "Почта" должно соответствовать маске "---@---.---"',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Пароль должен содержать не менее :min символов',
            'password.confirmed' => 'Поле "Пароль" и поле "Подтверждение пароля" не совпадают',
            'password.regex' => 'Пароль должен содержать минимум 1 заглавную букву и 1 цифру',
        ]);

        $user = User::create([
            'login' => $validatedData['login'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'is_admin' => ($validatedData['login'] == 'admin') ? true : false,
        ]);

        return redirect()->route('users.main');
    }
}
