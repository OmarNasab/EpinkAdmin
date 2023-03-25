
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>EPINK - Our Blog</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="https://tiwalasoft.com/dpms/css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container px-3">
                    <a class="navbar-brand" href="https://epink.health">EPINK</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
							<li class="nav-item"><a class="nav-link" href="https://epink.health/">Homepage</a></li>
							<li class="nav-item"><a class="nav-link" href="https://epink.health/blogs/">Blogs</a></li>
                        </ul>
                    </div>
                </div>
            </nav>  
			<div class="container">
<h1>Articles</h1>
<p>List of article</p>
<?php
$sql = "SELECT * FROM blogs";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$subcontent = substr($string, 0, strpos(wordwrap($row["content"], 100), "\n"));
			echo '<h3>'.$row["title"].'</h3> 
			'.$subcontent.'
			<p>Pubslished on '.$row["publishing_date"].' by Epink Admin - <a href="'.$domain.'blogs/'.$row["permalink"].'">Read here</a></p>';
		}
	} else {
		$row["status"] = "fail";
		$row["message"] = "Database is empty";
		$data = $row;
	}

?>
</div>
		</main>
        <!-- Footer-->
        <footer class="bg-light py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-grey">Copyright &copy; EPINK </div></div>
                    <div class="col-auto">
                        <a class="link-secondary text-grey small" href="#!">Privacy</a>
                        <span class="text-grey mx-1">&middot;</span>
                        <a class="link-secondary small" href="#!">Terms</a>
                        <span class=" mx-1">&middot;</span>
                        <a class="link-secondary small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="https://tiwalasoft.com/dpms/js/global.js"></script>
        <!-- Core theme JS-->
        <script src="https://tiwalasoft.com/dpms/js/scripts.js"></script>
    </body>
</html>