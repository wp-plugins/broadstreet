<?php require dirname(__FILE__) . '/global/_header.php' ?>

<?php if(@$error): ?>
    <div class="alert alert-error">
        Whoops! <?php echo $error ?>
    </div>
<?php endif; ?>

<h2>Step 1: Upload An Ad (any size, any format)</h2>

<div class="divider"></div>

<div class="hero">
    <img alt="Phone to ad" width="450" src="<?php echo Broadstreet_Mini_Utility::getBaseURL('assets/img/before-after.png') ?>" />
</div>

<div class="divider"></div>

<div class="left-col">
    <p>The first step is to upload a plain old ad. The only difference is that
    you'll want to leave some space for where you advertiser's text will go,
    like in the before/after example above.</p>
    
</div>

<div class="right-col">
        <div class="upload-form">
        <form id="bs-upload-ad" method="post" enctype="multipart/form-data" action="<?php echo Broadstreet_Mini_Utility::getBaseURL('index.php?action=upload') ?>">
            <span style="display: none;" id="use-sample-text">
                <strong>You're using a sample ad</strong>. <a id="upload-file" href="#">Click here to upload a file instead</a>.
            </span>
            <input type="file" id="form_file" name="file" title="Upload an image, like a jpg, gif, or png" />
            <input type="hidden" id="form_use_sample" name="use_sample" value="" />
        </form>
    </div>
    
    <p>
        <a rel="track" id="use-sample" href="#">Use A Sample Ad Instead</a>
    </p>
</div>

<div class="right-col right">
    <a id="submit" style="margin: 25px 25px 0 0;" class="btn call-to-action" href="#">Next Step &raquo;</a>
</div>

<div class="clearfix"></div>

<script>
    $('#submit').click(function(e) {
        e.preventDefault();
        _gaq.push(['_trackEvent', 'Clicks', 'Upload Ad']);
        $('#bs-upload-ad').submit();
    });
    
    $('#use-sample').click(function(e) {
        e.preventDefault();
        $('#form_use_sample').val('1');
        $('#use-sample-text').show();
        $('#use-sample').hide();
        $('#form_file').hide();
    });
    
    $('#upload-file').click(function(e) {
        e.preventDefault();
        $('#form_use_sample').val('');
        $('#use-sample-text').hide();
        $('#use-sample').show();
        $('#form_file').show();
    });
    
</script>
<script>
    $(function(){
        _gaq.push(['_trackEvent', 'Pages', 'Upload']);
    });
</script>
<?php require dirname(__FILE__) . '/global/_footer.php' ?>