<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> bsantanad </title>
  <meta name="viewport" content="width=device-width, inital-scale=1.0">
  <link href='../static/style.css' rel='stylesheet' type='text/css'/>
  <link href='../static/store-sales.css' rel='stylesheet' type='text/css'/>

  <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
  <script>hljs.highlightAll();</script>

</head>
<body>
<header>
  <h1><a href='../'>bsantanad</a></h1>
  <nav>
    <ul>
      <li><a href='../'><img width='38em' src='../static/images/folder.svg'>home</a></li>
      <li><a href='../blog.html' style='color: #ff3b30;'><img width='30em' src='../static/images/papers.svg'>blog</a></li>
      <li><a href='../illustrations.html'><img width='38em' src='../static/images/frame.svg'>illustrations</a></li>
      <li><a href='../about.html'><img width='30em' src='../static/images/about.svg'>about</a></li>
    </ul>
  </nav>
</header>
<main class='articles'>
<small><a href='../blog.html'>back</a></small>
<article>
<h1>store sales - data visualization</h1>
<p>Hello there, in this posts you'll find historical information of the sales by
the store <em>Favorita</em> down in Ecuador. The information will be organized in
colorful charts and pretty plots, hopefully I can show you some insights
on the store behavior throughout the years.</p>
<p>Let's start by checking the information we will be analysing.</p>
<h2>data</h2>
<p>We have some <code>csv</code>'s files with some relevant information of the store. All
the files we will see here go from 2013 to mid 2017. We got this information
from <a href="https://www.kaggle.com/competitions/store-sales-time-series-forecasting/data">kaggle.com</a>, so if you want to know more about what is in the
files or even download them you can go <a href="https://www.kaggle.com/competitions/store-sales-time-series-forecasting/data">over there</a> and check it for
yourself.</p>
<p>In case you are too lazy for that (I do not blame you), here is a summary on
what information we have:</p>
<ul>
<li>the price of oil throughout the period of time specified above. </li>
<li>sales by store and by family. (family meaning: groceries, automobile, etc..)</li>
<li>transactions by store </li>
<li>holiday events in ecuador</li>
<li>store information, like where is it located and so on.</li>
</ul>
<h2>what are we going to do</h2>
<p>Okay, now that you have an idea of the information we have, let me explain
what I'll be trying to show you.</p>
<p>First of all, the kaggle thing said that the oil price has a lot of impact in<br />
Ecuadors economy, so lets see if they are not lying to us.</p>
<p>Then it would be nice to see a map of Ecuador where we could see where are
located the top perfoming stores.</p>
<p>After that we will see how the top families/categories of products perfom
throughout the year.</p>
<p>Finally, let's see if we can find a relationship between holidays and
transactions.</p>
<p>In case you like bullet points better:
* oil vs transactions 
* map ecuador top stores
* top product categroies throughout the year
* holidays vs transactions</p>
<h2>is there a relationshiop between oil and transactions?</h2>
<p>well, the post said Ecuador is highly dependent on oil for its economy, let us
see, how well that holds up when we analyse the information.</p>
<h3>transactions</h3>
<p>So we have a loooot of information, on the transactions, meaning we have the
daily transaction for each day. So first lets get the average number of
transactions per month. Reducing the data a lot and letting us handle it 
better.</p>
<p>in case you want to see how to do this:</p>
<pre><code class="language-python">t = pd.read_csv('transactions.csv', parse_dates = ['date'])
t = t.set_index('date').resample('M').transactions.mean().reset_index()
</code></pre>
<p>Then we just need to plot that, and we are good to go. (we are using
seaborn for the chars/plots)</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/transactions_a.html'; ?>
</div>

<p>Although this plot looks nice, we can not make that many conclusions of out
it, we could maybe say that every time the last month of the year comes, the
sales go up by a lot, but by how much? Lets get the percentage change
month by month, meaning the difference between two months and see how much did
the transactions went up or down, see if there is a pattern or something</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/transactions_b.html'; ?>
</div>

<p>Okay, now we can see how when december comes it always comes up by the same
ammount we can confirm what we thought in the last plot, that this data has
seasonality, when december comes the transactions grow with respect to the
last month approximately, by 25 percent.</p>
<p>Now lets see if oil has a behavior that looks something similar</p>
<h3>oil</h3>
<p>Let's plot again, the average price of oil per month.</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/oil_a.html'; ?>
</div>

<p>Well at first it does not seem to have that much in common with the first one
we do not see the same seasonality. But hey, who are we to judge let's do
the percentage change thing and see if it looks alike to the transactions one.</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/oil_b.html'; ?>
</div>

<p>Mmm it does not seem to have the same behavior, nor seasonability.</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/oil_c.html'; ?>
</div>

<p>yeap, definetly no.</p>
<p>Let's just do a correclation table, to make sure we are not imagining things.</p>
<pre><code class="language-python"># where d and o are the transactions and oil dataframes
j = pd.merge(d, o, right_on = 'date', left_on = 'date')
j.corr()
</code></pre>
<p>output:</p>
<pre><code>
|              | transactions | dcoilwtico |
|--------------|--------------|------------|
| transactions | 1            | 0.229317   |
| dcoilwtico   | 0.229317     | 1          |
</code></pre>
<p>yeah, so I think we can see that there is no correlation between the number of
transactions and the oil price. </p>
<h2>top stores in map</h2>

</article>
</main>
</body>
</html>
