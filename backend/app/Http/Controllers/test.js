
const x = 2; 
let y = 4; 
function update(arg) { return Math.random() + y * arg; } 
y = 2;
y = 3;

const result = update(x);

for(let i = 0; i < 1000; i++) {
    let test = update(x);

    if(test < 6 || test > 7) {
        print(test, "WRONG!")
    }
}
// console.log(result)