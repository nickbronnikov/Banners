<?php
$LOCAL = array(
    'page404' => array(
        'index' => array(
            'title' => 'Страница 404',
            'h2' => '404 - такая страница не найдена.',
            'a' => 'На главную'
        )
    ),
    'admin' => array(
        'index_auth' => array(
            'title' => 'Войти в Banners',
            'form_title' => 'Войти',
            'errors' => array(
                'login' => 'Неверный логин',
                'password' => 'Неверный пароль'
            ),
            'form' => array(
                'login' => array(
                    'label' => 'Введите email или логин',
                    'placeholder' => 'Email или логин...',
                    'small' => ''
                ),
                'password' => array(
                    'label' => 'Введите пароль',
                    'placeholder' => 'Пароль...',
                    'small' => ''
                ),
                'button' => 'Войти'
            ),
            'registration' => 'Создать аккаунт'
        ),
        'registration' => array(
            'title' => 'Регистрация в Banners',
            'form_title' => 'Регистрация',
            'authorisation' => 'Уже есть аккаунт?',
            'form' => array(
                'name' => array(
                    'label' => 'Введите ваше имя',
                    'placeholder' => 'Ваше имя...',
                    'small' => ''
                ),
                'email' => array(
                    'label' => 'Введите ваш email',
                    'placeholder' => 'Email...',
                    'small' => ''
                ),
                'password' => array(
                    'label' => 'Введите пароль',
                    'placeholder' => 'Пароль...',
                    'small' => 'Пароль должен быть не короче 6 символов'
                ),
                'password_repeat' => array(
                    'label' => 'Повторите пароль',
                    'placeholder' => 'Повтор пароля...',
                    'small' => ''
                ),
                'button' => 'Регистрация',
                'created' => 'Ваш профиль создан'
            )
        ),
        'index' => array(
            'title' => 'Админ-панель',
            'h2' => 'Баннеры',
            'add_button' => 'Добавить баннер',
            'empty' => 'Пока здесь нет ни одного баннера.',
            'menu' => array(
                'list' => 'Список баннеров',
                'settings' => 'Настройки',
                'exit' => 'Выйти'
            ),
            'banner_item' => array(
                'edit' => 'Редактировать',
                'state' => array(
                    'important' => 'Важный баннер',
                    'disabled' => 'Баннер скрыт'
                )
            )
        ),
        'add' => array(
            'title' => 'Добавление баннера',
            'h2' => 'Новый баннер',
            'form' => array(
                'name' => array(
                    'label' => 'Название',
                    'placeholder' => 'Название...',
                    'small' => ''
                ),
                'url' => array(
                    'label' => 'URL баннера',
                    'placeholder' => 'URL...',
                    'small' => ''
                ),
                'state' => array(
                    'label' => 'Статус баннера',
                    'placeholder' => 'Выберете статус...',
                    'small' => '',
                    'options' => array(
                        'Обычный',
                        'Важный',
                        'Скрытый(не отображается на главной)'
                    )
                ),
                'sort' => array(
                    'label' => 'Позиция в списке',
                    'placeholder' => 'Укажите номер позиции...',
                    'small' => ''
                ),
                'image' => array(
                    'label' => 'Загрузите картинку',
                    'placeholder' => 'Загрузите картинку...',
                    'small' => ''
                ),
                'button' => 'Сохранить баннер'
            )
        ),
        'edit' => array(
            'title' => 'Редактирование баннера - ',
            'h2' => 'Редактирование баннера'
        )
    ),
    'main' => array(
        'index' => array(
            'title' => 'Banners - создавайте и просматривайте баннеры.',
            'h5' => 'Пока не один автор не добавил ни одного баннера'
        ),
        'all' => array(
            'admin_panel' => 'Админ-панель'
        )
    )
);