import resource from "../../../../../../core/src/resources/js/api/resource";
import QueryString from "../../../../../../core/src/resources/js/api/query-string";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/commerce"
  : "/badaso-api/module/commerce";

export default {
  browse(data = {}) {
    let ep = apiPrefix + "/v1/discount";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },
  
  add(data) {
    return resource.post(apiPrefix + "/v1/discount/add", data);
  },

  read(data) {
    let ep = apiPrefix + "/v1/discount/read";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  edit(data) {
    return resource.put(apiPrefix + "/v1/discount/edit", data);
  },

  delete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/discount/delete", paramData);
  },

  deleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/discount/delete-multiple", paramData);
  },

  browseBin(data = {}) {
    let ep = apiPrefix + "/v1/discount/bin";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  restore(data) {
    return resource.post(apiPrefix + "/v1/discount/restore", data);
  },

  restoreMultiple(data) {
    return resource.post(apiPrefix + "/v1/discount/restore-multiple", data);
  },

  forceDelete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/discount/force-delete", paramData);
  },

  forceDeleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/discount/force-delete-multiple", paramData);
  },
};
