<aside class="right-sidebar">
	<div class="widget">
		<form role="form">
		  <div class="form-group">
			<input type="text" class="form-control" id="s" placeholder="Поиск...">
		  </div>
		</form>
	</div>
	<div class="widget">
		<h5 class="widgetheading">Категории</h5>
		<ul class="cat">
			<?php $categories = Category::getAll(); ?>
			@foreach ($categories as $category)
				<li><i class="fa fa-angle-right"></i><a href="/category/{{ $category->slug }}">{{ $category->name }}</a><span> ({{ $category->sort }})</span></li>
			@endforeach
		</ul>
	</div>
	<div class="widget">
		<h5 class="widgetheading">Последние сообщения</h5>
		<ul class="recent">
			<li>
			<img src="/assets/img/blog/thumbs/thumb1.jpg" class="pull-left" alt="" />
			<h6><a href="#">Lorem ipsum dolor sit</a></h6>
			<p>
				 Mazim alienum appellantur eu cu ullum officiis pro pri
			</p>
			</li>
			<li>
			<a href="#"><img src="/assets/img/blog/thumbs/thumb2.jpg" class="pull-left" alt="" /></a>
			<h6><a href="#">Maiorum ponderum eum</a></h6>
			<p>
				 Mazim alienum appellantur eu cu ullum officiis pro pri
			</p>
			</li>
			<li>
			<a href="#"><img src="/assets/img/blog/thumbs/thumb3.jpg" class="pull-left" alt="" /></a>
			<h6><a href="#">Et mei iusto dolorum</a></h6>
			<p>
				 Mazim alienum appellantur eu cu ullum officiis pro pri
			</p>
			</li>
		</ul>
	</div>
	<div class="widget">
		<h5 class="widgetheading">Популярные теги</h5>
		<ul class="tags">
			<li><a href="#">Web design</a></li>
			<li><a href="#">Trends</a></li>
			<li><a href="#">Technology</a></li>
			<li><a href="#">Internet</a></li>
			<li><a href="#">Tutorial</a></li>
			<li><a href="#">Development</a></li>
		</ul>
	</div>
</aside>
