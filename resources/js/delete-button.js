import axios from "axios";


console.log("Delete Button Script Loaded");
$(document).on('click', '.delete-record', function(e) {
    e.preventDefault();
    const url = $(this).attr("data-url");
    console.log({url});

    $.confirm({
        title:'حذف شريك',
        content: '؟هل تريد حذف هذا بالفعل',
        buttons:{
            confirm:{
                text:'نعم ،أحذفه',
                btnClass: 'btn-red',
                action: function() {
                    axios.delete(url, {})
                    .then (response => {
                        console.log('Success Response:', response.data); // Log success
                            toastr.success(response.data.message);

                            if(window.partnerTable)
                            {
                                console.log('Reloading table...');
                                window.partnerTable.ajax.reload(null, false);
                                console.log('Table reloaded successfully');
                            }

                            if(window.transactionTable)
                            {
                                console.log('Reloading Transaction table...');
                                window.transactionTable.ajax.reload(null, false);
                                console.log('Transaction Table reloaded successfully');
                            }

                            if(window.manager)
                            {
                                console.log('Reloading Transaction table...');
                                window.manager.ajax.reload(null, false);
                                console.log('Transaction Table reloaded successfully');
                            }

                    })
                    .catch (error => {
                        toastr.error("هنا خطأ حمل الصفحة من جديد");
                    })
                }
            },
            cancel:{
                text:"إلغاء",
                btnClass: 'btn-gray'
            }
        }
    });

});

