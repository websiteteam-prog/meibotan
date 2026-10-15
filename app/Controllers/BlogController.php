<?php

namespace App\Controllers;

use App\Models\BlogModel;

use App\Models\BlogcatModel;

class BlogController extends BaseController
{

	private $blogmod;

	private $blogcatmod;

	public function __construct()
	{

		$this->blogmod = new BlogModel();

		$this->blogcatmod = new BlogcatModel();

	}

	public function manage_blog()
	{
		$metadata['page_title'] = "Meibotan Blog Post";
		$pager = service('pager');

		$count_product = $this->blogmod->countAllBlog();



		/*$perPage=20;

	 $total=$count_product;

	 $pager_links = $pager->makeLinks($page, $perPage, $total);*/

		$page = (int) $this->request->getGet('page'); //

		$perPage = 9; // see Config/Pager.php

		if (!isset($page) || $page === 0 || $page === 1) {

			$page = 1;

			$offset = 0;

		} else {

			$offset = ($page - 1) * $perPage;

			$page = $page;

		}

		$pager_links = $pager->makeLinks($page, $perPage, $count_product);

		$blogpostdata = $this->blogmod->getAllBlogWithPagination($perPage, $offset);

		$uri = service('uri');

		$segments = $uri->getSegments();

		$blogcatdata = $this->blogcatmod->getAllCategoryActive();

		return view('frontend/blog-main', ['blogpostdata' => $blogpostdata, 'blogcatdata' => $blogcatdata, 'segments' => $segments, 'pager_links' => $pager_links, 'perpage' => $perPage, 'metadata' => $metadata]);

	}

	public function manage_blogbycat($cat_slug)
	{
		$metadata['page_title'] = "Post by Categories";
		$catdata = $this->blogcatmod->getPerCategoryBySlug($cat_slug);

		$postcat_id = $catdata->postcat_id;

		$pager = service('pager');

		$count_product = $this->blogmod->countAllBlogPerCat($postcat_id);



		/*$perPage=20;

	 $total=$count_product;

	 $pager_links = $pager->makeLinks($page, $perPage, $total);*/

		$page = (int) $this->request->getGet('page'); //

		$perPage = 9; // see Config/Pager.php

		if (!isset($page) || $page === 0 || $page === 1) {

			$page = 1;

			$offset = 0;

		} else {

			$offset = ($page - 1) * $perPage;

			$page = $page;

		}

		$pager_links = $pager->makeLinks($page, $perPage, $count_product);

		$blogpostdata = $this->blogmod->getAllBlogCatWithPagination($postcat_id, $perPage, $offset);

		$uri = service('uri');

		$segments = $uri->getSegments();

		$blogcatdata = $this->blogcatmod->getAllCategoryActive();

		return view('frontend/blog-bycat', ['blogpostdata' => $blogpostdata, 'blogcatdata' => $blogcatdata, 'catdata' => $catdata, 'segments' => $segments, 'pager_links' => $pager_links, 'perpage' => $perPage, 'metadata' => $metadata]);

	}

	public function single_blog($post_slug)
	{

		$blogpostdata = $this->blogmod->getPerBlogpostBySlug($post_slug);

		// Wrong or deleted slug: return a proper 404 instead of a PHP error page
		if (empty($blogpostdata)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$uri = service('uri');

		$segments = $uri->getSegments();

		$blogcatdata = $this->blogcatmod->getAllCategoryActive();

		return view('frontend/blog-single', ['blogpostdata' => $blogpostdata, 'blogcatdata' => $blogcatdata, 'segments' => $segments]);

	}

}

?>
