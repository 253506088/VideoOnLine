<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    'admin'=>'admin/Login/LoginPage',
    'Login'=>'admin/Login/Login',
    'adminIndex'=>'admin/Login/adminIndex',
    'logout'=>'admin/Login/logout',
    /**************************************/
    'SetWebPage'=>'admin/SetWeb/SetWebPage',
    'getQRCode'=>'admin/SetWeb/getQRCode',
    'SetWeb'=>'admin/SetWeb/SetWeb',
    'getLogo'=>'admin/SetWeb/getLogo',
    /**************************************/
    'addCarouselimgPage'=>'admin/Carouselimg/addCarouselimgPage',
    'setCarouselimg'=>'admin/Carouselimg/setCarouselimg',
    'getCurrent'=>'admin/Carouselimg/getCurrent',
    'pageData'=>'admin/Carouselimg/pageData',
    'getCarouselimg'=>'admin/Carouselimg/getCarouselimg',
    'setCarouselimgPage'=>'admin/Carouselimg/setCarouselimgPage',
    'modifyCarouselimgPage'=>'admin/Carouselimg/modifyCarouselimgPage',
    'modifyCarouselimg'=>'admin/Carouselimg/modifyCarouselimg',
    'deleteCarouselimg'=>'admin/Carouselimg/deleteCarouselimg',
    /**************************************/
    'addGamePage'=>'admin/Game/addGamePage',
    'addGame'=>'admin/Game/addGame',
    'getGameImg'=>'admin/Game/getGameImg',
    'setGamePage'=>'admin/Game/setGamePage',
    'dataTable'=>'admin/Game/dataTable',
    'deleteGame'=>'admin/Game/deleteGame',
    'modifyGamePage'=>'admin/Game/modifyGamePage',
    'modifyGame'=>'admin/Game/modifyGame',
    /*************************************/
    'addNewsPage'=>'admin/News/addNewsPage',
    'addNews'=>'admin/News/addNews',
    'setNewsPage'=>'admin/News/setNewsPage',
    'setNews'=>'admin/News/setNews',
    'getNewsImg'=>'admin/News/getNewsImg',
    'getTextImg'=>'admin/News/getNewsImg',
    'newsDataTable'=>'admin/News/newsDataTable',
    'modifyNewsPage'=>'admin/News/modifyNewsPage',
    'deleteNews'=>'admin/News/deleteNews',
    /************************************/
    'setAboutAsPage'=>'admin/AboutAs/setAboutAsPage',
    'setAboutAs'=>'admin/AboutAs/setAboutAs',
    'getAboutAsImg'=>'admin/AboutAs/getAboutAsImg',
    /************************************/
    'addJoinUsPage'=>'admin/JoinUs/addJoinUsPage',
    'addJoinUs'=>'admin/JoinUs/addJoinUs',
    'setJoinUsPage'=>'admin/JoinUs/setJoinUsPage',
    'setJoinUs'=>'admin/JoinUs/setJoinUs',
    'joniUsDataTable'=>'admin/JoinUs/joniUsDataTable',
    'deleteJoinUs'=>'admin/JoinUs/deleteJoinUs',
    'modifyJoinUsPage'=>'admin/JoinUs/modifyJoinUsPage',
    /************************************/
    'addComicPage' => "admin/Comic/addComicPage",
    'addComic' => "admin/Comic/addComic",
    'addComicTypePage' => "admin/Comic/addComicTypePage",
    'addComicType' => "admin/Comic/addComicType",
    'adminComicTypePage' => "admin/Comic/adminComicTypePage",
    'comicTypeData' => "admin/Comic/comicTypeData",
    'setDeleteComicType' => "admin/Comic/setDeleteComicType",
    'deleteById' => "admin/Comic/deleteById",
    'modifiedComicTypeNamePage' => "admin/Comic/modifiedComicTypeNamePage",
    'modifiedComicTypeName' => "admin/Comic/modifiedComicTypeName",
    'getCoverImg' => "admin/Comic/getCoverImg",
    'getCoverVideo' => "admin/Comic/getCoverVideo",
    'test' => "admin/Comic/test",
    'adminComicPage' => "admin/Comic/adminComicPage",
    'comicData' => "admin/Comic/comicData",
    'setComicIs_deleted' => "admin/Comic/setComicIs_deleted",
    'deleteComic' => "admin/Comic/deleteComic",
    'unitTableModified' => "admin/Comic/unitTableModified",
    'modifiedComicPage' => "admin/Comic/modifiedComicPage",
    'modifiedComic' => "admin/Comic/modifiedComic",
    /************************************/
    'comicListIndex' => "admin/ComicList/comicListIndex",
    'playPage' => "admin/ComicList/playPage",
    /************************************/
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];
