<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\modules\recepty\models\Recepty;
use app\modules\article\models\Article;

/**
 * Site controller
 */
class SitemapController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {	
		$i = 0;
		$recepty = Recepty::findAll(['active' => 1]);        
        foreach ($recepty as $model){
            $sitemap[$i]['url'] = $model->url;
			$date_create = strtotime($model->date_create);
            $sitemap[$i]['date_create'] = date("Y-m-d",$date_create);
			$i++;
        }
		
		$article = Article::findAll(['active' => 1]);        
        foreach ($article as $model){
            $sitemap[$i]['url'] = $model->url;
            $sitemap[$i]['date_create'] = date("Y-m-d",$model->updated_at);
			$i++;
        }


        $sitemapData = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemapData .= '<urlset
			xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
			xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
			xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        foreach ($sitemap as $elem){
            $sitemapData .= '<url>
                <loc>' . Yii::$app->request->hostInfo . $elem['url'] . '</loc>
                <lastmod>' . $elem['date_create'] . '</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.5</priority>
            </url>';
        }
        $sitemapData .= '</urlset>'; 
		
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/xml');

		$sitemapData = gzencode($sitemapData);
		$headers->add('Content-Encoding', 'gzip');
		$headers->add('Content-Length', strlen($sitemapData));

        return $sitemapData;
    }

}
