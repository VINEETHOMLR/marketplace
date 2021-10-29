 google.load("elements", "1", {
            packages: "transliteration"
          });
      function onLoad() {
        var options = {
            sourceLanguage:
                google.elements.transliteration.LanguageCode.ENGLISH,
            destinationLanguage:
                [google.elements.transliteration.LanguageCode.MALAYALAM],
            shortcutKey: 'ctrl+g',
            transliterationEnabled: true
        };
 
        var control =
            new google.elements.transliteration.TransliterationControl(options);
   
        // Enable transliteration in the editable elements with id
        // 'transliterateDiv'.
      
        if(uri=="admin_categories")
        {
        var ids = [ "category_title" ];  
        }
        if(uri=="admin_subcategories")
        {
        var ids = [ "subcategory_title"  ];  
        }
        if(uri=="admin_subcategorieslevel3")
        {
        var ids = [ "subcategorylevel3_title"  ];  
        }
         if(uri=="admin_panchayath")
        {
        var ids = [ "panchayath_title"  ];  
        }
        if(uri=="admin_directories")
        {
        var ids = [ "directory_description"  ];  
        }
       
        if(uri=="admin_message")
        {

        var ids = [ "message_username","message_title","message_description"  ];  
        }

        if(uri=="admin_history")
        {

        var ids = [ "history_description","history_title" ];  
        }
        if(uri=="admin_website")
        {

        var ids = [ "website_description","website_title" ];  
        }
        if(uri=="admin_newspaper")
        {

        var ids = [ "newspaper_title" ];  
        }
        if(uri=="admin_cinema")
        {

        var ids = [ "cinema_title","cinema_description" ];  
        }
        if(uri=="admin_health")
        {

        var ids = [ "health_title","health_description" ];  
        }
        if(uri=="admin_foodcategory")
        {

        var ids = [ "category_title" ];  
        }
        if(uri=="admin_foodsubcategory")
        {

        var ids = [ "subcategory_title" ];  
        }
        if(uri=="admin_food")
        {

        var ids = [ "food_title","food_description" ];  
        }

        if(uri=="admin_about")
        {

        var ids = [ "about_description2","about_title"];  
        }



        

        
        control.makeTransliteratable(ids);
       // control.makeTransliteratable(['transliterateDiv2']);
      }
      google.setOnLoadCallback(onLoad);