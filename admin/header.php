<header id="top" class="modula-header" >
	<h1 class="header center-on-small-only">Modula Lite</h1>
	<h4 class="light  text-lighten-4 center-on-small-only"><?php print $tg_subtitle ?></h4>	
</header>

<?php if(! isset($nobanner)) : ?>
<a id="modula-survey" class="typeform-share button" href="https://greentreelabs.typeform.com/to/Ieyk9T" data-mode="1" target="_blank">
	<img src="<?php print plugins_url('/images/survey.png',__file__) ?>" alt="Survey">
	<span>I'd love a feedback from you! Please complete a short survey and get a <strong>10% discount</strong> for a Modula full license!</span>
</a>
<script>(function(){var qs,js,q,s,d=document,gi=d.getElementById,ce=d.createElement,gt=d.getElementsByTagName,id='typef_orm',b='https://s3-eu-west-1.amazonaws.com/share.typeform.com/';if(!gi.call(d,id)){js=ce.call(d,'script');js.id=id;js.src=b+'share.js';q=gt.call(d,'script')[0];q.parentNode.insertBefore(js,q)}id=id+'_';if(!gi.call(d,id)){qs=ce.call(d,'link');qs.rel='stylesheet';qs.id=id;qs.href=b+'share-button.css';s=gt.call(d,'head')[0];s.appendChild(qs,s)}})()</script>
<?php endif ?>