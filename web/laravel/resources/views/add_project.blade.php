@extends('layouts.app')

@section('content')
   
   <div class="temp_content">
       Hierin komt de veranderlijke content.
       Voor deze pagina zal dat dus een form zijn met alle velden om een nieuw project aan te maken.
       
       <form method="post">
           
           <div>
               <label for="name">Naam:</label>
               <input id="name" name="name" type="text">
           </div>
           
           <div>
               <label for="description">Beschrijving:</label>
               <textarea id="description" name="description"></textarea>
           </div>
           
           <div>
               <label for="startdate">Startdatum:</label>
               <input id="startdate" name="startdate" type="date">
           </div>
           
           <div>
               <input type="checkbox" name="hidden" id="hidden">
               <label for="hidden">Verborgen zetten</label>
           </div>
           
           <div>
               <label for="street">Straat:</label>
               <input id="street" name="street" type="text">
           </div>
           
           <div>
               <label for="number">Nummer:</label>
               <input id="number" name="number" type="number">
           </div>
           
           <div>
               <label for="image">Afbeelding:</label>
               <input type="file" id="image" name="image">
           </div>
           
       </form>
       
       
       <div>
           Hier moet ook nog ineens een form komen om direct een nieuwe fase toe te voegen.
           Dit kunnen we misschien best doen met een @ include van een andere blade, aangezien we dit toch ook nog nodig hebben op de aparte pagina "fase toevoegen".
           Als we dit met een @ include" doen, vermijden we dus dubbele code (of gaan we dit met angular doen??)
       </div>
       
   </div>
   
@endsection