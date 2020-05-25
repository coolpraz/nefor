<template>
    <div class="row justify-content-center">
        <ais-instant-search index-name="threads" :search-client="searchClient" :routing="routing">
            <div class="col-md-8">
                <ais-hits>
                	<div slot="item" slot-scope="{ item }">
	                    <a :href="item.path">
	                        <ais-highlight :hit="item" attribute="title"></ais-highlight>
	                    </a>
                	</div>
                </ais-hits>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        Search
                    </div>

                    <div class="card-body">
                        <ais-search-box :autofocus="true">
                        	<div slot-scope="{ currentRefinement, isSearchStalled, refine }">
                        		<input
                        			type="search"
                        			v-model="currentRefinement"
                        			@input="refine($event.currentTarget.value)"
                        			class="form-control"
                        			placeholder="Find a thread..."
                        		>
                        		<span :hidden="!isSearchStalled">Loading...</span>
                        	</div>
                        </ais-search-box>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        Filter By Channel
                    </div>

                    <div class="card-body">
                        <ais-refinement-list attribute="channel.name"></ais-refinement-list>
                    </div>
                </div>
            </div>
        </ais-instant-search>
    </div>
</template>

<script>
	import algoliasearch from 'algoliasearch/lite';
	import { history as historyRouter } from 'instantsearch.js/es/lib/routers';
	import { simple as simpleMapping } from 'instantsearch.js/es/lib/stateMappings';

    export default {
    	props: ['routeUri'],

    	data() {

            return {
                searchClient: algoliasearch(
                	process.env.MIX_ALGOLIA_APP_ID,
                	process.env.MIX_ALGOLIA_KEY
                ),
                routing: {
                	router: historyRouter(),
                	stateMapping: simpleMapping(),
                },
            }
        },
    }
</script>

<style>
	.ais-InstantSearch {
		display: contents;
	}
</style>