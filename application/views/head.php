<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SWApp</title>

	<link href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic&subset=latin' rel='stylesheet' type='text/css'>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>

	<!-- Compiled CSS and JS -->
	<link rel="stylesheet" href="assets/dist/styles/main.css">
	<script src="assets/dist/scripts/main.js"></script>	
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
  <script>
      // Add a Modernizr-test for the weird, inbetween, flexbox implementation
      // in IE10, necessary for the "sticky" footer.
      // (See https://github.com/Modernizr/Modernizr/issues/812)
      // (This could be rolled into a custom Modernizr build in production later.)
      Modernizr.addTest('flexboxtweener', Modernizr.testAllProps('flexAlign', 'end', true));
  </script>
</head>