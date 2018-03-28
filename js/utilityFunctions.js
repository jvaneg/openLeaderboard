function toggleElement(elementName)
{
    var x = document.getElementById(elementName);
    if (x.style.display === "none")
    {
        x.style.display = "block";
    }
    else
    {
        x.style.display = "none";
    }
}

function toggleTwoElements(elem1, elem2)
{
    toggleElement(elem1);
    toggleElement(elem2);
}
