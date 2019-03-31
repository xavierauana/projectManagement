<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
      <div class="table-responsive p-1">
          <div class="">
	          <div class="form-group px-0 col-md-5 col-lg-4 ml-auto">
		          <form>
			          <div class="input-group">
				          <input type="text" class="form-control"
				                 name="keyword"
				                 value="{{request()->query('keyword')}}"
				                 placeholder="Search Keyword"
				                 aria-label="Search Keyword"
				                 aria-describedby="basic-addon2" />
				          <div class="input-group-append">
					          <button class="btn btn-outline-info"
					                  type="submit">Search
					          </button>
					  </div>
	              </div>
              </form>
          </div>
      </div>
      <my-table inline-template>
        {{$slot}}
      </my-table>
      </div>
	  <div class="row px-1">
		  <div class="col-md-10">
			{{$paginator->appends(request()->query())->links()}}
		  </div>
		  <div class="col">
			  <p>Total: {{$paginator->total()}}</p>
		  </div>
	</div>
  </div>
</div>