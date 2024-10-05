const targetUrls = ["index3.php", "index4.php", "index5.php"]

fetch("http://52.221.67.113/smartlift/Moniter/Elevator.php")
  // .then(function (Response)
  //     {
  //         return Response.json()
  //     }
  // )
  // .then(function(data)
  //     {
  //         appendData(data)
  //         console.log(data)
  //     }
  // )
  // .catch(function (err)
  //     {
  //         console.log('error: ' + err)
  //     }
  // )
  .then(Response => Response.json())
  .then(data => {
    console.log(data);
    appendData(data);
  }
  )
  .catch(err => {
    console.log('error: ' + err)
  })

function appendData(data) {

  var maincontainer = document.getElementById("col-4");
  for (var i = 0; i < data.length; i++) {
    for (var key in data[i]) {
      var div = document.createElement("div");
      div.classList.add("content1")
      div.innerHTML = key + ": " + data[i][key];
      const link = document.createElement("a")
      link.href = targetUrls[i]
      link.target = "_blank"
      link.appendChild(div)
      maincontainer.appendChild(link);
    }
  }
}

