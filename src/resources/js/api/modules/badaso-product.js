import resource from "../../../../../../core/src/resources/js/api/resource";
import QueryString from "../../../../../../core/src/resources/js/api/query-string";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/commerce"
  : "/badaso-api/module/commerce";

export default {
  browse(data = {}) {
    let ep = apiPrefix + "/v1/product";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },
  
  add(data) {
    return resource.post(apiPrefix + "/v1/product/add", data);
  },

  read(data) {
    let ep = apiPrefix + "/v1/product/read";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  edit(data) {
    return resource.put(apiPrefix + "/v1/product/edit", data);
  },

  delete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/product/delete", paramData);
  },

  deleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/product/delete-multiple", paramData);
  },

  browseBin(data = {}) {
    let ep = apiPrefix + "/v1/product/bin";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  restore(data) {
    return resource.post(apiPrefix + "/v1/product/restore", data);
  },

  restoreMultiple(data) {
    return resource.post(apiPrefix + "/v1/product/restore-multiple", data);
  },

  forceDelete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/product/force-delete", paramData);
  },

  forceDeleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/product/force-delete-multiple", paramData);
  },
};
