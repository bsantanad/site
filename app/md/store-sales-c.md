## what are the top stores? 

In the dataset we have information on 54 stores, ones will perform
better or worse than the other ones, I think it might have something to do
with the location of the stores.

So let's get the top stores by sales.
```
top = sales.groupby('store_nbr').sales.sum().sort_values().reset_index()
top = top.tail(10)
```

<img src='../static/plots/top.svg'>

output:

```
|   | store_nbr | sales        | city      | state      | type | cluster |
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
```

as we can see a lot of them are located in pichincha, I wonder where is
pichincha in a map, do you know where it is? well let's find out.

we can use geopandas to load a map of ecuador, and color the state where this
top 10 stores are:

```
ecuador = geopandas.read_file(url)
continental = ecuador.cx[-82:,:]
provinces = continental.dissolve('DPA_DESPRO')

## more code

t = pd.merge(top, provinces, left_on = 'state', right_on = 'provinces')
```

<h1>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/map.html'; ?>
</div>
</h1>

Cool, as we can see the _redest_ part of the map is where the stores sales are
highest, since only 3 of them have stores with the most sales, we only see
those states in color:

- pichincha
- guayas 
- tungurahua 

Let's move to our third point then.

## top categories throughout the year

Let's see if the top family (categories) of products changed according to the
month. With the intention of knowing if when christmas comes closer, certain
category of product raises, or if they are the same throughout the whole year.

let's first see what are the top ten categories with most sales, this
is similar to the dataframe operation we did in the prior point. 

```
top_fam = top_fam.sort_values(by = 'sales').tail(10).family
```
doing this we get the following ten (the last being the highest one)
```
DELI
PERSONAL CARE
MEATS
POULTRY
BREAD/BAKERY
DAIRY
CLEANING
PRODUCE
BEVERAGES
GROCERY I
```

Now we just need to group them by month and get the mean across all the years
at each month. Now we only need to use plolty to graph

<h1>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/pyplot.html'; ?>
</div>
</h1>

Before you move anything, the graph will look a little wierd, that is becuase
it is a summary of the interactive animation.

Now, don't be shy, use your mouse to move around the plot, if you hover over
the bars you'll see which category each represents.

As you can see even though the sales have a bump in december, the top 3
categories do not change. It seems like they are persistent throught the whole
year.


## do sales increase near holidays? 

We are all humans, and we bring to any piece of research we do our
assumptions, our understanding of how the world works and so on. So it is only
natural for us to think that sales would increase when a holiday (like
christmas) comes near. Right? 

Basically what we are going to do is the following:
- get all sales from 2013 
- get all national holidays in 2013
- see if the daily number of sales is related to the national holidays

okay so using some good old fashion pure python we can get that pretty easily.
The algorithm is O(nxm) and probably can get optimized, but I leave that for
the reader to do :).

```
# where s is the sales dataframe, and he is the holiday events df
for i, date in enumerate(s.date):
    p = 1000
    tmp = []
    for h in he.date:
        td = (date - h)
        td = int((td / np.timedelta64(1, 'D')))
        td = abs(td)
        if td < p:
            p = td
    s.at[i, 'timedelta until holiday'] = p
```

Then we just graph `s` and we are good to go:

<h1>
<div class='plot'>
<?php include  __DIR__.'/../static/plots/td.html'; ?>
</div>
</h1>

As we can see in the x axis we have the days until the next holiday, and in the
y axis the sales. The blue line is the mean of the sales at any given date.  It
is really hard to tell if there is really a difference accordingly to how close
the date is to a holiday. Yes, the plot shows that the day 0, 1, and 2 are the
highest sales, but not by that many. We woul have to make a full statistical
analysis to say anything concrete.

But IMHO, I think we can not assume the closer we are to a holiday the more
sales we are going to have.


## final thoughts

well I hope you found the graphs pretty and insightful, if you do that's great,
if you don't well that's is not so great.

I'll leave some resources if you want to do your charts/plots/graphs:

<ul>
<li>
<a href='https://mpld3.github.io'> how to make a chart/plot with mpl and d3</a>
</li>
<li>
<a href='https://seaborn.pydata.org'> seaborn docs </a>
</li>
<ul>
