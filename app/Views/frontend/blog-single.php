<?php $commfrontfunc = service('commfrontfunc'); ?>
<?php
// ---- SEO: meta title / description / image alt (fall back to title + excerpt) ----
$seo_title = !empty($blogpostdata->post_meta_title)
	? $blogpostdata->post_meta_title
	: $blogpostdata->post_title . ' | Meibotan';

$seo_desc = !empty($blogpostdata->post_meta_description)
	? $blogpostdata->post_meta_description
	: ($blogpostdata->post_excerpt ?? '');
$seo_desc = trim(preg_replace('/\s+/', ' ', strip_tags($seo_desc)));

$seo_img_alt = !empty($blogpostdata->post_image_alt)
	? $blogpostdata->post_image_alt
	: $blogpostdata->post_title;

$seo_url = site_url('blog/' . $blogpostdata->post_slug);

$seo_img = CUSTOM_UPLOAD_PATH . "uploads/post/default.png";
if (!empty($blogpostdata->post_photo)) {
	$seo_img = CUSTOM_UPLOAD_PATH . $blogpostdata->post_photo;
}
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title><?php echo esc($seo_title); ?></title>
	<meta name="description" content="<?php echo esc($seo_desc); ?>" />
	<meta name="author" content="Ankush Sharma" />
	<link rel="canonical" href="<?php echo esc($seo_url); ?>" />

	<!-- Social sharing (WhatsApp, Facebook, LinkedIn) -->
	<meta property="og:type" content="article" />
	<meta property="og:site_name" content="Meibotan" />
	<meta property="og:title" content="<?php echo esc($seo_title); ?>" />
	<meta property="og:description" content="<?php echo esc($seo_desc); ?>" />
	<meta property="og:url" content="<?php echo esc($seo_url); ?>" />
	<meta property="og:image" content="<?php echo esc($seo_img); ?>" />
	<meta property="og:image:alt" content="<?php echo esc($seo_img_alt); ?>" />
	<meta name="twitter:card" content="summary_large_image" />

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>/assets/frontend/images/favicon.png" />
	<script>
		WebFontConfig = {
			google: {
				families: ["Open+Sans:300,400,600,700,800", "Poppins:300,400,500,600,700,800", "Oswald:300,400,500,600,700,800"],
			},
		};
		(function (d) {
			var wf = d.createElement("script"),
				s = d.scripts[0];
			wf.src = "<?php echo base_url(); ?>/assets/frontend/js/webfont.js";
			wf.async = true;
			s.parentNode.insertBefore(wf, s);
		})(document);
	</script>

	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css"
		href="<?php echo base_url(); ?>/assets/frontend/vendor/fontawesome-free/css/all.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/style.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/demo4.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/frontend/css/custom.css" />

	<style type="text/css">
		/* ===================================================================
	 BLOG DETAIL — Meibotan brand redesign (teal / mobile responsive)
	 =================================================================== */
		.main.blog-detail {
			background: linear-gradient(170deg, #ECFEFF 0%, #F8FAFC 40%, #F5F8FB 100%);
			padding-bottom: 60px;
		}

		/* ---------- Breadcrumb ---------- */
		.main.blog-detail .breadcrumb-nav {
			background: transparent;
			padding: 37px 0 50px;
		}

		.main.blog-detail .breadcrumb {
			background: transparent;
			padding: 0;
			margin: 0;
		}

		.main.blog-detail .breadcrumb-item,
		.main.blog-detail .breadcrumb-item a {
			font-size: 13px;
			color: #6B7280;
			text-decoration: none;
		}

		.main.blog-detail .breadcrumb-item a:hover {
			color: #0F766E;
		}

		.main.blog-detail .breadcrumb-item.active {
			color: #0F766E;
			font-weight: 600;
		}

		.main.blog-detail .breadcrumb-item+.breadcrumb-item::before {
			color: #CBD5E1;
		}

		/* ---------- Article card ---------- */
		.bd-article {
			background: #fff;
			border: 1px solid #EEF2F6;
			border-radius: 16px;
			overflow: hidden;
			box-shadow: 0 6px 22px rgba(15, 118, 110, .06);
		}

		.bd-media {
			position: relative;
			margin: 0;
			background: #F1F5F9;
		}

		.bd-media img {
			display: block;
			width: 100%;
			max-height: auto;
			object-fit: cover;
		}

		.bd-body {
			padding: 26px 30px 34px;
		}

		/* meta row: date chip + category chip */
		.bd-meta {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 10px;
			margin-bottom: 14px;
		}

		.bd-chip {
			display: inline-flex;
			align-items: center;
			gap: 7px;
			font-family: 'Oswald', sans-serif;
			font-size: 12px;
			font-weight: 500;
			letter-spacing: .4px;
			text-transform: uppercase;
			padding: 6px 13px;
			border-radius: 30px;
			line-height: 1;
			text-decoration: none;
		}

		.bd-chip.date {
			background: #F1F5F9;
			color: #475569;
		}

		.bd-chip.cat {
			background: #E6F7F4;
			color: #0F766E;
		}

		.bd-chip.cat:hover {
			background: #0F766E;
			color: #fff;
		}

		.bd-chip i {
			font-size: 12px;
		}

		.bd-title {
			font-family: 'Poppins', sans-serif;
			font-size: 30px;
			line-height: 1.28;
			font-weight: 700;
			color: #1F2937;
			margin: 0 0 18px;
		}

		.bd-divider {
			height: 3px;
			width: 60px;
			background: linear-gradient(90deg, #0F766E, #14B8A6);
			border-radius: 3px;
			margin: 0 0 22px;
		}

		/* ---------- Post content typography ---------- */
		.bd-content {
			font-family: 'Open Sans', sans-serif;
			font-size: 15.5px;
			line-height: 1.85;
			color: #374151;
			word-wrap: break-word;
		}

		.bd-content p {
			margin: 0 0 18px;
		}

		.bd-content img {
			max-width: 100%;
			height: auto;
			border-radius: 12px;
			margin: 8px 0 20px;
		}

		.bd-content h1,
		.bd-content h2,
		.bd-content h3,
		.bd-content h4 {
			font-family: 'Poppins', sans-serif;
			color: #1F2937;
			font-weight: 600;
			line-height: 1.35;
			margin: 26px 0 12px;
		}

		.bd-content h2 {
			font-size: 23px;
		}

		.bd-content h3 {
			font-size: 20px;
		}

		.bd-content h4 {
			font-size: 17px;
		}

		.bd-content a {
			color: #0F766E;
			text-decoration: underline;
		}

		.bd-content a:hover {
			color: #14B8A6;
		}

		.bd-content ul,
		.bd-content ol {
			margin: 0 0 18px;
			padding-left: 22px;
		}

		.bd-content li {
			margin-bottom: 8px;
		}

		.bd-content blockquote {
			margin: 20px 0;
			padding: 14px 20px;
			background: #F0FBF9;
			border-left: 4px solid #0F766E;
			border-radius: 0 10px 10px 0;
			color: #334155;
			font-style: italic;
		}

		.bd-content table {
			max-width: 100%;
		}

		.bd-content iframe {
			max-width: 100%;
		}

		/* ===================================================================
		   MOBILE CATEGORY STRIP  (horizontal swipe pills — desktop par hidden)
		   =================================================================== */
		.bd-cat-strip {
			display: none;
		}

		.bd-cat-strip-head {
			display: flex;
			align-items: center;
			gap: 8px;
			font-family: 'Poppins', sans-serif;
			font-size: 14px;
			font-weight: 600;
			color: #1F2937;
			margin: 0 0 10px;
		}

		.bd-cat-strip-head i {
			color: #0F766E;
			font-size: 14px;
		}

		.bd-cat-scroller {
			display: flex;
			flex-wrap: nowrap;
			gap: 8px;
			overflow-x: auto;
			padding-bottom: 4px;
			-webkit-overflow-scrolling: touch;
			scrollbar-width: none;
		}

		.bd-cat-scroller::-webkit-scrollbar {
			display: none;
		}

		.bd-cat-pill {
			flex: 0 0 auto;
			display: inline-flex;
			align-items: center;
			gap: 7px;
			white-space: nowrap;
			background: #fff;
			border: 1px solid #E2E8F0;
			color: #475569;
			font-size: 13px;
			font-weight: 500;
			padding: 8px 14px;
			border-radius: 30px;
			text-decoration: none;
			box-shadow: 0 2px 8px rgba(15, 118, 110, .04);
		}

		.bd-cat-pill .pill-count {
			font-size: 11px;
			font-weight: 700;
			background: #F1F5F9;
			color: #94A3B8;
			border-radius: 20px;
			padding: 1px 7px;
			line-height: 1.5;
		}

		.bd-cat-pill.active {
			background: #0F766E;
			border-color: #0F766E;
			color: #fff;
		}

		.bd-cat-pill.active .pill-count {
			background: rgba(255, 255, 255, .22);
			color: #fff;
		}

		/* ---------- Sidebar ---------- */
		.bd-sidebar .widget {
			background: #fff;
			border: 1px solid #EEF2F6;
			border-radius: 16px;
			padding: 20px 22px 22px;
			margin-bottom: 24px;
			box-shadow: 0 6px 22px rgba(15, 118, 110, .05);
		}

		.bd-widget-title {
			font-family: 'Poppins', sans-serif;
			font-size: 16px;
			font-weight: 600;
			color: #1F2937;
			margin: 0 0 16px;
			padding-bottom: 12px;
			border-bottom: 1px solid #EEF2F6;
			display: flex;
			align-items: center;
			gap: 9px;
		}

		.bd-widget-title i {
			color: #0F766E;
			font-size: 15px;
		}

		/* category list */
		.bd-cat-list {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.bd-cat-list li {
			margin: 0 0 4px;
		}

		.bd-cat-list li:last-child {
			margin-bottom: 0;
		}

		.bd-cat-list a {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 10px;
			padding: 9px 13px;
			border-radius: 10px;
			font-size: 14px;
			color: #475569;
			text-decoration: none;
			transition: background .18s, color .18s;
		}

		.bd-cat-list a:hover {
			background: #E6F7F4;
			color: #0F766E;
		}

		.bd-cat-list a .cat-name {
			display: flex;
			align-items: center;
			gap: 9px;
		}

		.bd-cat-list a .cat-name::before {
			content: "";
			width: 6px;
			height: 6px;
			border-radius: 50%;
			background: #CBD5E1;
			flex: 0 0 auto;
			transition: background .18s;
		}

		.bd-cat-list a:hover .cat-name::before {
			background: #0F766E;
		}

		.bd-cat-list .cat-count {
			font-size: 12px;
			font-weight: 600;
			color: #94A3B8;
			background: #F1F5F9;
			border-radius: 20px;
			padding: 2px 9px;
			min-width: 24px;
			text-align: center;
		}

		/* active category (current post's category) */
		.bd-cat-list li.active a {
			background: #0F766E;
			color: #fff;
			font-weight: 600;
		}

		.bd-cat-list li.active a .cat-name::before {
			background: #14B8A6;
		}

		.bd-cat-list li.active .cat-count {
			background: rgba(255, 255, 255, .22);
			color: #fff;
		}

		/* related posts */
		.bd-related {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.bd-related li {
			display: flex;
			gap: 12px;
			align-items: center;
			padding: 10px 0;
			border-bottom: 1px dashed #EDF1F5;
		}

		.bd-related li:first-child {
			padding-top: 0;
		}

		.bd-related li:last-child {
			border-bottom: 0;
			padding-bottom: 0;
		}

		.bd-related .rp-thumb {
			flex: 0 0 auto;
			width: 58px;
			height: 58px;
			border-radius: 10px;
			overflow: hidden;
			background: #F1F5F9;
		}

		.bd-related .rp-thumb img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}

		.bd-related .rp-info {
			min-width: 0;
		}

		.bd-related .rp-info a {
			display: block;
			font-family: 'Poppins', sans-serif;
			font-size: 13.5px;
			font-weight: 500;
			line-height: 1.4;
			color: #1F2937;
			text-decoration: none;
			margin-bottom: 4px;
		}

		.bd-related .rp-info a:hover {
			color: #0F766E;
		}

		.bd-related .rp-meta {
			font-size: 12px;
			color: #94A3B8;
			display: flex;
			align-items: center;
			gap: 5px;
		}

		.bd-related .rp-meta i {
			color: #0F766E;
		}

		/* sticky sidebar on desktop */
		@media (min-width: 992px) {
			.bd-sidebar-inner {
				position: sticky;
				top: 90px;
			}
		}

		/* ===================================================================
		   RESPONSIVE — mobile par categories ko UPAR strip me dikhao,
		   sidebar wali categories chhupao (taaki bottom me na aaye)
		   =================================================================== */
		@media (max-width: 991px) {
			.main.blog-detail .breadcrumb-nav {
				padding: 20px 0 22px;
			}

			/* upar wali horizontal category strip ON */
			.bd-cat-strip {
				display: block;
				margin-bottom: 20px;
			}

			/* sidebar ki vertical category widget OFF (ab neeche nahi aayegi) */
			.bd-cat-widget {
				display: none;
			}

			.bd-sidebar {
				margin-top: 26px;
			}

			/* agar sidebar me sirf category thi (koi related post nahi),
			   to mobile par extra khaali space na aaye */
			.bd-sidebar:empty,
			.bd-sidebar-inner:empty {
				display: none;
				margin: 0;
			}
		}

		@media (max-width: 575px) {
			.bd-body {
				padding: 22px 18px 26px;
			}

			.bd-title {
				font-size: 21px;
			}

			.bd-media img {
				max-height: 260px;
			}

			.bd-content {
				font-size: 15px;
			}

			.main.blog-detail {
				padding-bottom: 40px;
			}
		}
	</style>
</head>

<body>
	<div class="page-wrapper">
		<?= $this->include('frontend/partials/header') ?>
		<main class="main blog-detail">

			<?php
			// ---- current post's category (breadcrumb + active highlight) ----
			$catdata = $blogpostdata->post_category;
			$active_title = "";
			$active_slug = "";

			// ---- category list ek hi baar build karo (count query dobara na chale) ----
			$blogservice = service('blogservice');
			$cat_render = [];
			if (!empty($blogcatdata)) {
				foreach ($blogcatdata as $bc) {
					$is_active = ($bc->postcat_id == $catdata);
					if ($is_active) {
						$active_title = $bc->postcat_title;
						$active_slug = $bc->postcat_slug;
					}
					$cat_render[] = [
						'slug' => $bc->postcat_slug,
						'title' => $bc->postcat_title,
						'count' => $blogservice->countAllBlogPerCat($bc->postcat_id),
						'active' => $is_active,
					];
				}
			}

			// ---- featured image ----
			$blog_img = CUSTOM_UPLOAD_PATH . "uploads/post/default.png";
			$post_photo = $blogpostdata->post_photo;
			if ($post_photo != "") {
				$blog_img = CUSTOM_UPLOAD_PATH . $post_photo;
			}

			// ---- related posts ----
			$relpostdata = $blogservice->getRelatedPost($catdata, $blogpostdata->post_id);
			?>

			<nav aria-label="breadcrumb" class="breadcrumb-nav">
				<div class="container">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>"><i class="fas fa-home"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="<?php echo site_url("blog"); ?>">Blog</a></li>
						<?php if ($active_title != "") { ?>
							<li class="breadcrumb-item"><a
									href="<?php echo site_url("blog-category/$active_slug"); ?>"><?php echo $active_title; ?></a>
							</li>
						<?php } ?>
						<li class="breadcrumb-item active" aria-current="page"><?php echo $blogpostdata->post_title; ?>
						</li>
					</ol>
				</div><!-- End .container -->
			</nav>

			<div class="container">

				<!-- ===== MOBILE-ONLY category strip (article ke upar, swipe-able) ===== -->
				<?php if (count($cat_render) > 0) { ?>
					<div class="bd-cat-strip">
						<div class="bd-cat-strip-head"><i class="fas fa-layer-group"></i> Blog Categories</div>
						<div class="bd-cat-scroller">
							<?php foreach ($cat_render as $c) { ?>
								<a href="<?php echo site_url("blog-category/" . $c['slug']); ?>"
									class="bd-cat-pill<?php echo $c['active'] ? ' active' : ''; ?>">
									<?php echo $c['title']; ?>
									<span class="pill-count"><?php echo $c['count']; ?></span>
								</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<div class="row">

					<!-- ============ ARTICLE ============ -->
					<div class="col-lg-8">
						<article class="bd-article">
							<figure class="bd-media">
								<img src="<?php echo $blog_img; ?>" alt="<?php echo esc($seo_img_alt); ?>"
									onerror="this.onerror=null;this.src='<?php echo CUSTOM_UPLOAD_PATH; ?>uploads/post/default.png';">
							</figure>

							<div class="bd-body">
								<div class="bd-meta">
									<span class="bd-chip date">
										<i class="far fa-calendar-alt"></i>
										<?php echo date('d M Y', strtotime($blogpostdata->post_pubdate)); ?>
									</span>
									<?php if ($active_title != "") { ?>
										<a href="<?php echo site_url("blog-category/$active_slug"); ?>" class="bd-chip cat">
											<i class="fas fa-tag"></i> <?php echo $active_title; ?>
										</a>
									<?php } ?>
								</div>

								<h1 class="bd-title"><?php echo $blogpostdata->post_title; ?></h1>
								<div class="bd-divider"></div>

								<div class="bd-content">
									<?php echo $blogpostdata->post_content; ?>
								</div>
							</div><!-- End .bd-body -->
						</article>
					</div><!-- End .col-lg-8 -->

					<!-- ============ SIDEBAR ============ -->
					<aside class="col-lg-4 bd-sidebar">
						<div class="bd-sidebar-inner">

							<!-- Blog Categories (desktop sidebar; mobile par hidden) -->
							<div class="widget bd-cat-widget">
								<h4 class="bd-widget-title"><i class="fas fa-layer-group"></i> Blog Categories</h4>
								<ul class="bd-cat-list">
									<?php foreach ($cat_render as $c) { ?>
										<li<?php echo $c['active'] ? ' class="active"' : ''; ?>>
											<a href="<?php echo site_url("blog-category/" . $c['slug']); ?>">
												<span class="cat-name"><?php echo $c['title']; ?></span>
												<span class="cat-count"><?php echo $c['count']; ?></span>
											</a>
											</li>
										<?php } ?>
								</ul>
							</div>

							<!-- Related Posts -->
							<?php if (count($relpostdata) > 0) { ?>
								<div class="widget">
									<h4 class="bd-widget-title"><i class="far fa-newspaper"></i> Related Posts</h4>
									<ul class="bd-related">
										<?php foreach ($relpostdata as $relpostrow) {
											$relpost_slug = $relpostrow->post_slug;
											$rel_photo = $relpostrow->post_photo ?? '';
											$rel_img = ($rel_photo != "") ? CUSTOM_UPLOAD_PATH . $rel_photo
												: CUSTOM_UPLOAD_PATH . "uploads/post/default.png";
											$rel_alt = !empty($relpostrow->post_image_alt) ? $relpostrow->post_image_alt : $relpostrow->post_title;
											?>
											<li>
												<a href="<?php echo site_url("blog/$relpost_slug"); ?>" class="rp-thumb">
													<img src="<?php echo $rel_img; ?>"
														alt="<?php echo esc($rel_alt); ?>"
														onerror="this.onerror=null;this.src='<?php echo CUSTOM_UPLOAD_PATH; ?>uploads/post/default.png';">
												</a>
												<div class="rp-info">
													<a
														href="<?php echo site_url("blog/$relpost_slug"); ?>"><?php echo $relpostrow->post_title; ?></a>
													<div class="rp-meta">
														<i class="far fa-clock"></i>
														<?php echo date('M d, Y', strtotime($relpostrow->post_pubdate)); ?>
													</div>
												</div>
											</li>
										<?php } ?>
									</ul>
								</div>
							<?php } ?>

						</div><!-- End .bd-sidebar-inner -->
					</aside><!-- End .col-lg-4 -->

				</div><!-- End .row -->
			</div><!-- End .container -->
		</main>

		<?= $this->include('frontend/partials/footer') ?>
		<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/optional/isotope.pkgd.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/plugins.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.appear.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/main.min.js"></script>
</body>

</html>
