#6.16 Generate Non-Uniform Random Numbers
Suppose you need to write a load test for a server.  You have studied the inter-arrival time of requests to the server
over a period of one year and from this data have computed a histogram of the distribution of the inter-arrival time of
requests.  In the load test you would like to generate requests for the server such that the inter-arrival times come
from the same distribution that was observed in the historical data.  The following problem formalizes the generation
of inter-arrival times.
You are given n real number t0, t1, ..., tn-1 and probabilities p0, p1, ..., pn-1, which sum up to 1.  Given a random
number generator that produces values in [0, 1] uniformly, how would you generate a number in T according to the
specified probabilities?