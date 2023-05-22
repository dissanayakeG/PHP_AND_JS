console.log(fibonacci(700));

//filling array for given n
function fib(n) {
  if (n === 0) {
    return [0];
  }

  let fib = [0, 1];

  for (let i = 2; i <= n; i++) {
    fib[i] = fib[i - 1] + fib[i - 2];
  }

  return fib.slice(0, n); //to return only the first n elements, excluding the extra undefined values.
}

//finding sum of previous values upto n, when n is given
function fibonacci(n){
  if(n==0){
    return 0;
  }
  if(n==1){
    return 1;
  }

  return fibonacci(n-1) + fibonacci(n-2)
  //if n=5 --> fibonacci(4)+fibonacci(3)
  //       -->[ fibonacci(3)+fibonacci(2) ] + [ fibonacci(2)+fibonacci(1) ]
  //       -->[ fibonacci(2)+fibonacci(1) ] + [ fibonacci(1)+fibonacci(0) ] + [ fibonacci(1)+fibonacci(0) ] + 1
  //       -->[ fibonacci(1)+fibonacci(0) ] + 1  + [ 1+0 ] + [ 1+0 ] + 1
  //       -->[ 1+0 ] + 1 + [ 1+0 ] + [ 1+0 ] + 1
  //       -->5 //0,1,1,2,3,5<-,8,13,21....
}
