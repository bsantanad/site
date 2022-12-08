# store sales - data visualization

Hello there, in this posts you'll find historical information of the sales by
the store _Favorita_ down in Ecuador. The information will be organized in
colorful charts and pretty plots, hopefully I can show you some insights
on the store behavior throughout the years.

Let's start by checking the information we will be analysing.

## data

We have some `csv`'s files with some relevant information of the store. All
the files we will see here go from 2013 to mid 2017. We got this information
from [kaggle.com][kaggle], so if you want to know more about what is in the
files or even download them you can go [over there][kaggle] and check it for
yourself.

In case you are too lazy for that (I do not blame you), here is a summary on
what information we have:

- the price of oil throughout the period of time specified above. 
- sales by store and by family. (family meaning: groceries, automobile, etc..)
- transactions by store 
- holiday events in ecuador
- store information, like where is it located and so on.

## what are we going to do

Okay, now that you have an idea of the information we have, let me explain
what I'll be trying to show you.

First of all, the kaggle thing said that the oil price has a lot of impact in  
Ecuadors economy, so lets see if they are not lying to us.

Then it would be nice to see a map of Ecuador where we could see where are
located the top perfoming stores.

After that we will see how the top families/categories of products perfom
throughout the year.

Finally, let's see if we can find a relationship between holidays and
transactions.

In case you like bullet points better:
* oil vs transactions 
* map ecuador top stores
* top product categroies throughout the year
* holidays vs transactions


## is there a relationshiop between oil and transactions?

well, the post said Ecuador is highly dependent on oil for its economy, let us
see, how well that holds up when we analyse the information.

### transactions

So we have a loooot of information, on the transactions, meaning we have the
daily transaction for each day. So first lets get the average number of
transactions per month. Reducing the data a lot and letting us handle it 
better.

in case you want to see how to do this:
```
t = pd.read_csv('transactions.csv', parse_dates = ['date'])
t = t.set_index('date').resample('M').transactions.mean().reset_index()
```

Then we just need to plot that, and we are good to go. (we are using
seaborn for the chars/plots)

<h1>
<?php require_once '../static/plots/transaction_a.html'; ?>
</h1>

Although this plot looks nice, we can not make that many conclusions of out
it, we could maybe say that every time the last month of the year comes, the
sales go up by a lot, but by how much? Lets get the percentage change
month by month, meaning the difference between two months and see how much did
the transactions went up or down, see if there is a pattern or something

<h1>
<?php require_once '../static/plots/transaction_b.html'; ?>
</h1>

Okay, now we can see how when december comes it always comes up by the same
ammount we can confirm what we thought in the last plot, that this data has
seasonality, when december comes the transactions grow with respect to the
last month approximately, by 25 percent.

Now lets see if oil has a behavior that looks something similar

### oil

Let's plot again, the average price of oil per month.

<h1>
<?php require_once '../static/plots/oil_a.html'; ?>
</h1>

Well at first it does not seem to have that much in common with the first one
we do not see the same seasonality. But hey, who are we to judge let's do
the percentage change thing and see if it looks alike to the transactions one.

<h1>
<?php require_once '../static/plots/oil_b.html'; ?>
</h1>

Mmm it does not seem to have the same behavior, nor seasonability.

<h1>
<?php require_once '../static/plots/oil_c.html'; ?>
</h1>

yeap, definetly no.

Let's just do a correclation table, to make sure we are not imagining things.

```
# where d and o are the transactions and oil dataframes
j = pd.merge(d, o, right_on = 'date', left_on = 'date')
j.corr()
```
output:

|              | transactions | dcoilwtico |
|--------------|--------------|------------|
| transactions | 1            | 0.229317   |
| dcoilwtico   | 0.229317     | 1          |

yeah, so I think we can see that there is no correlation between the number of
transactions and the oil price. 

## top stores in map

[kaggle]: https://www.kaggle.com/competitions/store-sales-time-series-forecasting/data

