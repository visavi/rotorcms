<?php

Class HomeController Extends BaseController {

	/**
	 * Главная страница
	 */
	public function index()
	{
		App::view('index');
	}

	/**
	 * Проверочный код
	 */
	public function captcha()
	{
		header('Content-type: image/jpeg');

		$phrase = new Gregwar\Captcha\PhraseBuilder;
		$phrase = $phrase->build(5, '0123456789');

		$builder = new Gregwar\Captcha\CaptchaBuilder($phrase);
		$builder->setBackgroundColor(mt_rand(220,255), mt_rand(220,255), mt_rand(220,255));
		$builder->build()->output();

		$_SESSION['captcha'] = $builder->getPhrase();
	}

	/**
	 * Счет на оплату
	 */
	public function invoice()
	{
		$user = User::get();
		if (empty($user->company_name)
			|| empty($user->company_inn)
			|| empty($user->company_kpp)
			|| empty($user->company_address))
		{
			App::setFlash('danger', 'Для формирования счета на оплату необходимо заполнить поля (Название компании, адрес, ИНН и КПП)');
			App::redirect('user/edit');
		}

		App::view('invoice', compact('user'));

		// Отправляем письмо
		$message = 'От пользователя <a href="http://'.Setting::get('sitelink').'/user/'.$user->getId().'">'.e($user->getFullName()).'</a> поступил новый счет на оплату';

		$headers['from'] = [$user->email => $user->getFullName()];
		$to = [Setting::get('email') => Setting::get('admin')];
		$subject = 'Новый счет на оплату';
		$body = App::view('mailer.default', compact('subject', 'message'), true);

		// Отправка письма
		App::sendMail($to, $subject, $body, $headers);
	}

	/**
	 * Обратная связь
	 */
	public function contact()
	{
		$request = Request::input('request');

		if (App::requestMethod() == 'POST') {

			$email = Request::input('email');
			$name = Request::input('name');
			$message = Request::input('message');
			$captcha = Request::input('captcha');

			$errors = [];
			if (!App::isMail($email)) $errors['email'] = 'Неверный формат адреса email';
			if (!$name) $errors['name'] = 'Небходимо заполнить имя отправителя';
			if (!$message) $errors['message'] = 'Необходимо заполнить текст сообщения';
			if ($captcha != $_SESSION['captcha']) $errors['captcha'] = 'Неверный проверочный код';

			if (!$errors) {
				$message = nl2br(e($message));

				$to = [Setting::get('email') => Setting::get('admin')];
				$subject = 'Новое письмо с сайта';
				$body = App::view('mailer.contact', compact('subject', 'message', 'request'), true);
				$headers['from'] = [$email => $name];

				// Отправка письма
				App::sendMail($to, $subject, $body, $headers);

				App::setFlash('success', 'Письмо успешно отправлено!');
				App::redirect('/');
			} else {
				App::setFlash('danger', $errors);
				App::setInput($_POST);
				App::redirect('/contact');
			}
		}

		App::view('pages.contact', compact('request'));
	}
}
