<?php
use yii\helpers\Html;
?>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[facebook][url]', isset($socialMedia['facebook']['url']) ? $socialMedia['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls', 'placeholder' => 'Enter Facebook ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($socialMedia['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Facebook ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[twitter][url]', isset($socialMedia['twitter']['url']) ? $socialMedia['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls', 'placeholder' => 'Enter Twitter ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($socialMedia['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Twitter ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[instagram][url]', isset($socialMedia['instagram']['url']) ? $socialMedia['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls', 'placeholder' => 'Enter Instagram ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($socialMedia['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Instagram ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[linkedin][url]', isset($socialMedia['linkedin']['url']) ? $socialMedia['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls', 'placeholder' => 'Enter Linkedin ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($socialMedia['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Linkedin ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[blog][url]', isset($socialMedia['blog']['url']) ? $socialMedia['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls', 'placeholder' => 'Enter Blog ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($socialMedia['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Blog ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[interest][url]', isset($socialMedia['interest']['url']) ? $socialMedia['interest']['url'] : '', ['class' => 'form-control social_interest readonlyCls', 'placeholder' => 'Enter Interest ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[interest][name]', isset($socialMedia['interest']['url']) ? 'interest' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Interest ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($socialMedia['rss_feed']['url']) ? $socialMedia['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls', 'placeholder' => 'Enter RSS Feed ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($socialMedia['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter RSS Feed ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[youtube][url]', isset($socialMedia['youtube']['url']) ? $socialMedia['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls', 'placeholder' => 'Enter Youtube ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($socialMedia['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter Youtube ID']) ?>
</div>
<div class="form-group">
<?= Html::textInput('SocialMediaLink[google][url]', isset($socialMedia['google']['url']) ? $socialMedia['google']['url'] : '', ['class' => 'form-control social_google readonlyCls', 'placeholder' => 'Enter google ID']) ?>
<?= Html::hiddenInput('SocialMediaLink[google][name]', isset($socialMedia['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls', 'placeholder' => 'Enter google ID']) ?>
</div>