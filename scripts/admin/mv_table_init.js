'use strict'
import mvTableLoader from '../plugins/mvTableLoader'


let $table = $( '<table>' );
$table.appendTo( $( '#js-table-table' ) );

let options = {
    tableConfig : tableConfig,
    actions : actions,
   // formConfig : formConfig,
    uniqueId : 'id',
   
};

new mvTableLoader( $table , options );

