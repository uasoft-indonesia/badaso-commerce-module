import resource from "../../../../../../core/src/resources/js/api/resource";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/commerce"
  : "/badaso-api/module/commerce";

export default {
  add(data) {
    return resource.post(apiPrefix + "/v1/product-detail/add", data);
  },

  edit(data) {
    return resource.put(apiPrefix + "/v1/product-detail/edit", data);
  },

  delete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/product-detail/delete", paramData);
  },
};
