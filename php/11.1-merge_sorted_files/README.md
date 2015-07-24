# 11.1 Merge Sorted Files
You are given 500 files, each containing stock trade information for an S&P 500 company.  Each trade is encoded by a
line as follows:
1232111,AAPL,30,456.12
The first number is the time of the trade expressed as the number of milliseconds since the start of the day's trading.
Lines within each file are sorted in increasing order of time.  The remaining values are the stock symbol, number of
shares and price.  You are to create a single file containing all the trades from the 500 files, sorted in order of
increasing trade times.  The individual files are of the order of 5-100 megabytes.  The combined file will be on the
order of 5 gigabytes.

Design an algorithm that takes a set of files containing stock trades sorted by increasing trade times and writes a
single file containing the trades appearing in the individual files sorted in the same order.  The algorithm should use
very little RAM, ideally of the order of a few kilobytes.