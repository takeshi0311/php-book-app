<?php

namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 */
class AppController extends Controller
{
    /**
     * 初期化処理
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        //loadComponentメソッドの第一引数にAuthコンポーネントを指定する
        // 第2引数にAuthコンポーネントの設定をする
        $this->loadComponent('Auth', [
            // 'authenticate'キーでFormによる認証を行い、認証キーはusersテーブルのusernameとpasswordカラムと照合させる
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ],
            // ログイン時のアクション
            'loginAction' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            // ログイン時のリダイレクト先
            'loginRedirect' => [
                'controller' => 'Questions',
                'action' => 'index'
            ],
            // ログアウト時のリダイレクト先
            'logoutRedirect' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            // 未認証時のリダイレクト先を指定
            'unauthorizedRedirect' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            'authError' => 'ログインが必要です'
        ]);
        // allow()メソッドは認証が不要なアクションを設定することができる。
        // 参照系の画面はログインしていなくても参照できる仕様のためindexアクションとviewアクションを指定
        $this->Auth->allow(['display', 'index', 'view']);
    }
}
