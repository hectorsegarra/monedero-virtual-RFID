<?php
$language = Yii::$app->language;
$sourceLanguage = Yii::$app->sourceLanguage;


if (is_file(Yii::getAlias("@app/views/site/cookies/{$language}.php"))) {
    echo $this->render("cookies/$language");
} else {
    echo $this->render("cookies/$sourceLanguage");
}