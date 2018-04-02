var inputText = document.getElementById("txt"),
    items = document.querySelectorAll("#list li"),
    tab = [],
    index = -1;

for(var i = 0; i < items.length; i++){
    tab.push(items[i].innerHTML);
}

for(var i = 0; i < items.length; i++){
    items[i].onclick = function () {
        index = tab.indexOf(this.innerHTML);
        console.log(this.innerHTML + " index = " + index)
    };
}

function deleteListItem() {

    if(index != -1 &&  items[index].parentNode.childNodes.length > 0)
    {
        items[index].parentNode.removeChild(items[index]);
    }
}

function addListItem() {

    if(inputText.value != "")
    {
        var link = "category.php";
        var li, a, text;

        li = document.createElement('li');
        a  = document.createElement('a');
        text = document.createTextNode(inputText.value);

        a.href = link;
        a.appendChild(text);
        li.appendChild(a);
        document.querySelector("#list").appendChild(li);
    }
}


function addLink()
{
    // var a = document.getElementById(event.srcElement.id);
    // a.href = "category.php";
}
