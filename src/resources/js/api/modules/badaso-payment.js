import resource from "../../../../../../core/src/resources/js/api/resource";
import QueryString from "../../../../../../core/src/resources/js/api/query-string";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/commerce"
  : "/badaso-api/module/commerce";

export default {
  browse(data = {}) {
    let ep = apiPrefix + "/v1/payment";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  add(data) {
    return resource.post(apiPrefix + "/v1/payment/add", data);
  },

  read(data) {
    let ep = apiPrefix + "/v1/payment/read";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  edit(data) {
    return resource.put(apiPrefix + "/v1/payment/edit", data);
  },

  delete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/payment/delete", paramData);
  },

  deleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/payment/delete-multiple", paramData);
  },

  browseOption(data = {}) {
    let ep = apiPrefix + "/v1/payment/option";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  addOption(data) {
    return resource.post(apiPrefix + "/v1/payment/option/add", data);
  },

  editOption(data) {
    return resource.put(apiPrefix + "/v1/payment/option/edit", data);
  },

  arrangeOption(data) {
    return resource.put(apiPrefix + "/v1/payment/option/arrange", data);
  },

  deleteOption(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/payment/option/delete", paramData);
  },
};
