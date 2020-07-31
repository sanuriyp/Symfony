  //to delete functin articles is the id of delete button
const articles = document.getElementById('articles');

if (articles){
    articles.addEventListener('click', (e) =>{
       //alert('You clicked the delete button');
       //the delete-article is the class used in delete button in index.html.twig
       if (e.target.className === 'btn btn-danger delete-article'){
        // alert('You clicked the delete button');

        //the alert confirmation
        if (confirm('Are you sure?')) {
        //data-id is the attribute in delete button
           const id = e.target.getAttribute('data-id');

           //alert(id);
           //fetch the backend
           fetch(`/article/delete/${id}`, {
               method: 'DELETE'
               }).then(res => window.location.reload());
          }
        }   
    
    });
}