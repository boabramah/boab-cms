<html>
<head>
	<title></title>
	<style>
	*{padding: 0px;margin:0px;}
	.clear{clear:both;}
	h2{margin-bottom: 20px}
	p{margin-bottom: 10px}
	body{padding-top:50px;background-color:#3B3B3B;width:800px;margin: 0px auto;min-height: 400px}
	#wrapper{background-color: #fff;border-top: 2px solid #F97A14}
	#subject{background-color: #FAF8F8;line-height: 50px;font-size: 15px;padding: 0px 20px}
	#content{padding: 20px;line-height: 1.3em}
	#footer{background:#F97A14 url(/images/social.png) no-repeat center center;height: 100px}
	#top{color:#fff;background-color: #F97A14;line-height: 40px;text-align: center;text-transform: uppercase;}
	</style>
</head>
<body>
	<div id="wrapper">
		<div id="top">Email Template</div>
		<h2 id="subject"><?php echo $this->subject;?></h2>
		<div id="content"><?php echo $this->content;?></div>
		<div id="footer"></div>
		<div class="clear"></div>
	<div>
</body>
</html>