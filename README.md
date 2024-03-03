<h1 align="center">**Wish List**</h1>
<p margonTop="20px">This is a *microservice application* for creating personalized gift lists.</p>
<p maarginTop="20px">Our application consists of three microservices: <p>
<ol>
<li>*the authentication service*, responsible for providing necessary access and user authentication.</li>
<li>*the wishlist service*, allowing users to create and view their own wishlists as well as browse through their friends' wishlists.</li>
<li>*the recommendation service*, which generates personalized gift recommendations based on the user's wishlist.</li>
</ol>

<h2>Authentication service</h2>
<p>[POST]</p>
<ol>
<li>~api/auth/login</li>
<li>~api/auth/logout</li>
<li>~api/auth/signin/</li>
</ol>
<p>[GET]</p>
<ol>
<li>~api/auth/role-id</li>
</ol>

<h2>WishList service</h2>
<p>[POST]</p>
<ol>
<li>~api/list</li>
<li>~api/list/id</li>
</ol>
<p>[GET]</p>
<ol>
<li>~api/list/{id}</li>
<li>~api/list</li>
<li>~api/list/tags</li>
<li>~api/list/friends/{id}</li>
<li>
</ol>
<p>[DELETE]</p>
<ol>
<li>~api/list/{id}</li>
<li>~api/list/friends/{id}</li>
</ol>

<h2>Recommendation service</h2>
<p>[POST]</p>
<ol>
<li>~api/recommendation</li>
<li>~api/recommendation/{id}</li>
</ol>
<p>[GET]</p>
<ol>
<li>~api/recommendation/{id}</li>
<li>~api/recommendation</li>
<li>
</ol>
<p>[DELETE]</p>
<ol>
<li>~api/recommendation/{id}</li>
</ol>
