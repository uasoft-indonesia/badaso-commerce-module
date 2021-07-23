import resource from "../../../../../../core/src/resources/js/api/resource";
import QueryString from "../../../../../../core/src/resources/js/api/query-string";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/commerce"
  : "/badaso-api/module/commerce";

export default {
  browse(data = {}) {
    let ep = apiPrefix + "/v1/order";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  read(data) {
    let ep = apiPrefix + "/v1/order/read";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  confirm(data) {
    return resource.post(apiPrefix + "/v1/order/confirm", data);
  },

  reject(data) {
    return resource.post(apiPrefix + "/v1/order/reject", data);
  },

  ship(data) {
    return resource.post(apiPrefix + "/v1/order/ship", data);
  },

  setTrackingNumber(data) {
    return resource.post(apiPrefix + "/v1/order/tracking-number", data);
  },

  done(data) {
    return resource.post(apiPrefix + "/v1/order/done", data);
  },
};
