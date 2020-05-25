<template>
    <div>
        <div v-if="signedIn">
        	<div class="form-group">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
        	    <!-- <textarea name="body" 
        	    	id="body" 
        	    	class="form-control" 
        	    	placeholder="Have something to say?" 
        	    	rows="5"
        	    	required 
        	    	v-model="body"></textarea> -->
        	</div>
        	
        	<button type="submit" 
        		class="btn btn-outline-dark"
        		@click="addReply">Post</button>
        </div>

	    <p class="text-center" v-else>
	    	Please <a href="/login">sign in</a> to participate in this discussion.
	    </p>
    </div>
</template>

<script>
    import Tribute from "tributejs";

    export default {
        data() {
            return {
                body: '',
                completed: false,
            }
        },

        mounted() {
            var tribute = new Tribute({
                // column to search against in the object (accepts function or string)
                lookup: 'value',

                // column that contains the content to insert by default
                fillAttr: 'value',

                values: function(query, cb) {
                    axios.get('/api/users', {params: {name: query}} )
                        .then(function (response) {
                            console.log(response.data);
                            cb(response.data);
                        });
                },

            });

            tribute.attach(document.querySelectorAll("#body"));
        },
        
        methods: {
            addReply() {
            	axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
            		.then(({data}) => {
            			this.body = '';
                        this.completed = true;

            			flash('Your reply has been posted.');

            			this.$emit('created', data);
            		});
            }
        },
    }
</script>