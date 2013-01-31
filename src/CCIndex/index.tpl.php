<h1>Index Controller</h1>
<p>Welcome to Brosephina index controller.</p>

<h2>Download</h2>
<p>You can download Brosephina from github.</p>
<blockquote>
<code>git clone git://github.com/brosephina/Brosephina2.0.git</code>
</blockquote>
<p>You can review its source directly on github: <a href='https://github.com/brosephina/Brosephina2.0'>https://github.com/brosephina/Brosephina2.0</a></p>

<h2>Installation</h2>
<p>First you have to make the data-directory writable. This is the place where Brosephina needs
to be able to write and create files.</p>
<blockquote>
<code>cd brosephina; chmod 777 site/data</code>
</blockquote>

<p>Second, You have to go in to the file .htaccess and change the code ~chpg11/DV1440/me/Brosephina2.0
to your own root and where you put your Brosephina2.0</p>
<p>Last, Brosephina has some modules that need to be initialised. You can do this through a 
controller. Point your browser to the following link.</p>
<blockquote>
<a href='<?=create_url('module/install')?>'>module/install</a>
</blockquote>
