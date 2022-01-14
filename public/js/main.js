//chercher par motclé
const chercher = (e) =>{
const motCle= document.getElementById("motCle");
e.preventDefault();
const mot = motCle.value;
window.location.replace('/livre/chercher/'+mot);
}
//lister par dates:
const lister = (e) =>{
    const date1= document.getElementById("dateDeb");
    const date2= document.getElementById("dateFin");
    const dateDeb= date1.value;
    const dateFin = date2.value;
    e.preventDefault();
    const mot = motCle.value;
    window.location.replace('/livre/chercher/entre_dates/'+dateDeb+'/'+dateFin);
    }
    //lister par note:
const filtrerParNote= (e) =>{
    window.location.replace('/livre/chercher/livresParNote/'+e.target.value);
    }
    //lister par date:
const filtrerParDate= (e) =>{
    let date= new Date(e.target.value).toISOString().slice(0,10);
    window.location.replace('/livre/chercher/livresParDate/'+date);
    }
     //lister par autheur:
const filtrerParAutheur= (e) =>{
    
    window.location.replace('/livre/chercher/livresParAutheur/'+e.target.value);
    }

     //lister par genre:
const filtrerParGenre= (e) =>{
    
    window.location.replace('/livre/chercher/livresParGenre/'+e.target.value);
    }