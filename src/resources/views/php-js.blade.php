<?php
// Passing data into a globally defined array variable.
$_uppish = array(
    'maxUploadSize' => config('uppish.upload_max_size'),
    'acceptedMimes' => Uppish::acceptedMimes(),
    'maximumFiles'  => config('uppish.maximum_files'),
    'routeUpload'   => route('uppish.upload'),
    'routeDelete'   => route('uppish.delete'),
);
?>
<script>
    /* <![CDATA[ */
        var uppish = '{!! json_encode($_uppish) !!}';
    /* ]]> */
</script>
