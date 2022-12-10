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
  <h1><a href='../../'>bsantanad</a></h1>
  <nav>
    <ul>
      <li><a href='../../'><img width='38em' src='../static/images/folder.svg'>home</a></li>
      <li><a href='../blog.html' style='color: #ff3b30;'><img width='30em' src='../static/images/papers.svg'>blog</a></li>
      <li><a href='../illustrations.html'><img width='38em' src='../static/images/frame.svg'>illustrations</a></li>
      <li><a href='../../'><img width='30em' src='../static/images/about.svg'>about</a></li>
    </ul>
  </nav>
</header>
<main class='articles'>
<small><a href='../blog.html'>back</a></small>
<article>
<h1>store sales - data visualization</h1>
<p>hello there, in this post you'll find historical information about sales made by
the store <em>Favorita</em> down in Ecuador (or maybe up I don't know where you live). The information will be organized in
colorful charts and pretty plots, and hopefully, I'll be able to show you some insights
into the store's behavior throughout the years.</p>
<p>Let's start by checking the information we will be analyzing.</p>
<h2>data</h2>
<p>We have some <code>csv</code>'s files with some relevant information about the store. All
the files here go from 2013 to mid-2017. We got this information
from <a href="https://www.kaggle.com/competitions/store-sales-time-series-forecasting/data">kaggle.com</a>, so if you want to know more about what is in the
files or download them you can go <a href="https://www.kaggle.com/competitions/store-sales-time-series-forecasting/data">over there</a> and check them for
yourself.</p>
<p>In case you are too lazy for to do that (I do not blame you), here is a summary of
what information we have:</p>
<ul>
<li>the price of oil throughout the period specified above. </li>
<li>sales by store and by family. (family meaning: groceries, automobile, etc..)</li>
<li>transactions by store </li>
<li>holiday events in ecuador</li>
<li>store information, like where is it located and so on.</li>
</ul>
<h2>what are we going to do?</h2>
<p>Okay, now that you have an idea of the information we have, let me explain
what I'll be trying to show you.</p>
<p>First of all, the kaggle thing said that the oil price has a lot of impact in<br />
Ecuadors economy, so let us see if they are not lying to us.</p>
<p>Then it would be nice to see a map of Ecuador where we could see where are
located the top performing stores.</p>
<p>After that, we will see how the top families/categories of products perform
throughout the year.</p>
<p>Finally, let's see if we can find a relationship between holidays and
sales.</p>
<p>In case you like bullet points better:<p>
<ul>
<li>oil vs transactions </li>
<li>map ecuador top stores </li>
<li>top product categories throughout the year </li>
<li>holidays vs sales</li>
</ul>
<h2>is there a relationship between oil and transactions?</h2>
<p>well, the post said Ecuador is highly dependent on oil for its economy, let us
see how well that holds up when we analyze the information.</p>
<h3>transactions</h3>
<p>So we have a loooot of information on transactions, meaning we have the
daily transactions made each day. So first let's get the average number of
transactions per month. Reducing the data and letting us handle it
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

<p>Although this plot looks nice, we can not make that many conclusions about
it, we could maybe say that every time the last month of the year comes, the
sales go up by a lot, but, by how much? Let us get the percentage change
month by month, meaning the difference between two months, and see how much
the transactions went up or down, see if there is a pattern or something</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/transactions_b.html'; ?>
</div>

<p>Okay, now we can see how when December comes, it always comes up by the same
amount we can confirm what we thought in the last plot, that this data has
seasonality, when December comes the transactions grow in respect to the
last month approximately, by 25 percent.</p>
<p>Now let us see if the oil has a behavior that looks something similar</p>
<h3>oil</h3>
<p>Let's plot again, the average price of oil per month.</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/oil_a.html'; ?>
</div>

<p>Well at first it does not seem to have that much in common with the first one.
We do not see the same seasonality. But hey, who are we to judge let's do
the percentage change thing and see if it looks like the transactions one.</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/oil_b.html'; ?>
</div>

<p>Mmm, it does not seem to have the same behavior, nor seasonability.</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/oil_c.html'; ?>
</div>

<p>yeap, definitely no.</p>
<p>Let's just do a correlation table, just to make sure we are not imagining things.</p>
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
<h2>what are the top stores?</h2>
<p>In the dataset we have information on 54 stores, ones will perform
better or worse than the other ones, I think it might have something to do
with the location of the stores.</p>
<p>we could just animate all the stores thru time</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/anim.html'; ?>
</div>
<p>but that looks king of ugly doesn't it?</p>
<p>So let's get the top stores by sales.</p>
<pre><code>top = sales.groupby('store_nbr').sales.sum().sort_values().reset_index()
top = top.tail(10)
</code></pre>
<div class='plot'>
<img src='../static/plots/top.svg'>
</div>
<p>output:</p>
<pre><code>|   | store_nbr | sales        | city      | state      | type | cluster |
|---|-----------|--------------|-----------|------------|------|---------|
| 0 | 50        | 2.865302E+07 | Ambato    | tungurahua | A    | 14      |
| 1 | 8         | 3.049429E+07 | Quito     | pichincha  | D    | 8       |
| 2 | 51        | 3.291149E+07 | Guayaquil | guayas     | A    | 17      |
| 3 | 48        | 3.593313E+07 | Quito     | pichincha  | A    | 14      |
| 4 | 46        | 4.189606E+07 | Quito     | pichincha  | A    | 14      |
| 5 | 49        | 4.34201E+07  | Quito     | pichincha  | A    | 11      |
| 6 | 3         | 5.048191E+07 | Quito     | pichincha  | D    | 8       |
| 7 | 47        | 5.094831E+07 | Quito     | pichincha  | A    | 14      |
| 8 | 45        | 5.449801E+07 | Quito     | pichincha  | A    | 11      |
| 9 | 44        | 6.208755E+07 | Quito     | pichincha  | A    | 5       |
</code></pre>
<p>as we can see a lot of them are located in pichincha, I wonder where
pichincha is on a map, do you know where it is? well let's find out.</p>
<p>we can use geopandas to load a map of ecuador, and color the state where this
top 10 stores are:</p>
<pre><code>ecuador = geopandas.read_file(url)
continental = ecuador.cx[-82:,:]
provinces = continental.dissolve('DPA_DESPRO')

## more code

t = pd.merge(top, provinces, left_on = 'state', right_on = 'provinces')
</code></pre>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/map.html'; ?>
</div>

<p>Cool, as we can see the <em>redest</em> part of the map is where the stores sales are
highest, since only 3 states have stores with the most sales, we only see
those states in color:</p>
<ul>
<li>pichincha</li>
<li>guayas </li>
<li>tungurahua </li>
</ul>
<p>Let's move to our third point then.</p>
<h2>top categories throughout the year</h2>
<p>Let's see if the top family (categories) of products changed according to the
month. With the intention of knowing if when Christmas comes closer, certain
category of product raises, or if they are the same throughout the whole year.</p>
<p>let's first see what are the top ten categories with most sales, this
is similar to the dataframe operation we did in the prior point. </p>
<pre><code class='language-python'>top_fam = top_fam.sort_values(by = 'sales').tail(10).family
</code></pre>
<p>doing this we get the following ten (the last being the highest one)</p>
<pre><code class='language-bash'>DELI
PERSONAL CARE
MEATS
POULTRY
BREAD/BAKERY
DAIRY
CLEANING
PRODUCE
BEVERAGES
GROCERY I
</code></pre>
<p>Now we just need to group them by month and get the mean across all the years
at each month. After that we use plolty to graph</p>
<p style='color: red;'> <b>IMPORTANT!!!</b></p>
<p style='color: red;'> <b>plotly didn't want to play nice, and did not let me embed the html chart, sorry about that.
i'll leave a xkcd comic where the other graph should be</b></p>
<em><a href='/public/static/plots/pyplot.html' target="_blank">but you can click here to see the plotly chart</a></em>
<br>
<br>
<div class='plot'>
<img src='https://imgs.xkcd.com/comics/convincing.png'>
</div>



<p>well, enough of that, back to the plotly graph...<p>
<p>Before you move anything, the graph will look a little weird, that is because
it is a summary of the interactive animation.</p>
<p>Now, don't be shy, use your mouse to move around the plot, if you hover over
the bars you'll see which category each represents.</p>
<p>As you can see even though the sales have a bump in december, the top 3
categories do not change. It seems like they are persistent through the whole
year.</p>
<h2>do sales increase near national holidays?</h2>
<p>We are all humans, and we bring to any piece of research we do our
assumptions, our understanding of how the world works and so on. So it is only
natural for us to think that sales would increase when a holiday (like
Christmas) comes near. Right? </p>
<p>Basically what we are going to do is the following:</p>
<ul>
<li>get all sales from 2013</li>
<li>get all national holidays in 2013</li>
<li>see if the daily number of sales is related to the national holidays</li>
<ul>
<p>okay so using some good old fashion pure python we can get that pretty easily.
The algorithm is O(nxm) and probably can get optimized, but I leave that for
the reader to do :).</p>
<pre><code class='language-python'># where s is the sales dataframe, and he is the holiday events df
for i, date in enumerate(s.date):
    p = 1000
    for h in he.date:
        td = (date - h)
        td = int((td / np.timedelta64(1, 'D')))
        td = abs(td)
        if td &lt; p:
            p = td
    s.at[i, 'timedelta until holiday'] = p
</code></pre>
<p>Then we just graph <code>s</code> and we are good to go:</p>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/td.html'; ?>
</div>

<p>As we can see in the x axis we have the days until the next holiday, and in the
y axis the sales. The blue line is the mean of the sales at any given day.  It
is really hard to tell if there is really a difference accordingly to how close
the date is to a holiday. Yes, the plot shows that the day 0, 1, and 2 are the
highest sales, but not by that much. We would have to make a full statistical
analysis to say anything concrete.</p>
<p>But IMHO, I think we can not assume the closer we are to a holiday the more
sales we are going to have.</p>
<h2>final thoughts</h2>
<p>well I hope you found the graphs pretty and insightful, if you do great!
if you didn't, well, that's is not so great.</p>
<p>I'll leave some resources in case you want to do your charts/plots/graphs:</p>
<ul>
<li>
<a href='https://mpld3.github.io'> how to make a chart/plot with mpl and d3</a>
</li>
<li>
<a href='https://seaborn.pydata.org'> seaborn docs </a>
</li>
<ul>

</article>
</main>
</body>
</html>
