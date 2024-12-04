<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Article;
use app\models\Topic;
use app\models\Comment;
use app\models\SearchForm;
use app\models\CommentForm;
use yii\data\Pagination;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionView($id)
    {

        $article = Article::findOne($id);

        $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();

        $recent = Article::find()->orderBy('date desc')->limit(3)->all();

        $topics = Topic::find()->all();
        $comments = $article->comments;

        $commentsParent = array_filter($comments, function ($k) {

            return $k['comment_id'] == null;

        });

        $commentsChild = array_filter($comments, function ($k) {

            return ($k['comment_id'] != null && !$k['delete']);

        });

        $commentForm = new CommentForm();

        return $this->render('single', [

            'article' => $article,

            'popular' => $popular,

            'recent' => $recent,

            'topics' => $topics,

            'commentsParent' => $commentsParent,

            'commentsChild' => $commentsChild,

            'commentForm' => $commentForm,

        ]);

        $article->viewedCounter();
    }
    public function actionSearch()

    {

        $model = new SearchForm();

        if (Yii::$app->request->isGet) {

            $model->load(Yii::$app->request->get());

            $data = $model->SearchAtricle(3);

            $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();

            $recent = Article::find()->orderBy('date desc')->limit(3)->all();

            $topics = Topic::find()->all();

            return $this->render('search',[

                'articles' => $data['articles'],

                'pagination' => $data['pagination'],

                'popular' => $popular,

                'recent' => $recent,

                'topics' => $topics,

                'search' => $model->text

            ]);

        }

    }
    public function actionComment($id, $id_comment = null)
    {

        $model = new CommentForm();

        if (Yii::$app->request->isPost) {

            $model->load(Yii::$app->request->post());

            if ($model->saveComment($id, $id_comment)) {

                return $this->redirect(['site/view', 'id' => $id]);

            }

        }

    }

    public function actionCommentDelete($id, $id_comment)
    {

        if (Yii::$app->request->isPost) {

            $data = Comment::findOne($id_comment);

            if ($data->user_id == Yii::$app->user->id) {

                $data->delete = true;

                $data->save(false);

            }

            return $this->redirect(['site/view', 'id' => $id]);

        }

    }
    public function actionTopic($id)
    {

        $query = Article::find()->where(['topic_id'=>$id]);


        $count = $query->count();


        // create a pagination object with the total count

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 2]);


        // limit the query using the pagination and retrieve the articles

        $articles = $query->offset($pagination->offset)

            ->limit($pagination->limit)

            ->all();


        $popular = Article::find()->orderBy('viewed desc')->limit(2)->all();

        $recent = Article::find()->orderBy('date desc')->limit(2)->all();

        $topics = Topic::find()->all();

        return $this->render('topic', [

            'articles' => $articles,

            'pagination' => $pagination,

            'popular' => $popular,

            'recent' => $recent,

            'topics' => $topics,

        ]);

    }


    public function actionIndex()
    {
        $query = Article::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 2]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        $popular = Article::find()->orderBy('viewed desc')->limit(2)->all();

        $recent = Article::find()->orderBy('date desc')->limit(2)->all();

        $topics = Topic::find()->all();

        return $this->render('index', [

            'articles' => $articles,
            'pagination' => $pagination,
            'popular' => $popular,
            'recent' => $recent,
            'topics' => $topics
        ]);

    }
    /**
     * Logout action.
     *
     * @return Response
     */


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
