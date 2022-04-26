<script>
import moment from "moment"
export default {

    methods: {

        $arraysplicer(item, array_given) {
            array_given.splice(array_given.indexOf(item), 1);
        },
        $arrayupdater(item, array_given) {
            array_given.unshift(item);
        },
        $defaultDate(date){
            return moment(date).format('DD-MM-YYYY');
        }
    }

}
</script>
