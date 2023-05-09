document.addEventListener("DOMContentLoaded", function () {
  const formWrapper = document.querySelector(".gform_wrapper");
  const template = formWrapper.querySelector("template");
  const fields = formWrapper.querySelectorAll(".gfield > [hidden]");
  const fieldsConfig = Array.from(fields).reduce((fields, field) => {
    const { fieldName, fieldType } = field.dataset;
    const doc = new DOMParser();
    const html = doc.parseFromString(field.innerHTML, "text/html");
    fields[fieldName] = {
      type: fieldType,
      name: fieldName,
      html,
    };

    return fields;
  }, {});

  const node = template.content.cloneNode(true);
  node.childNodes[0].innerHTML = node.childNodes[0].innerHTML.replace(
    /\[(.*?)\]/g,
    function (match, inputName) {
      const field = fieldsConfig[inputName];
      if (!field) return "";
      let inputNode;
      if (field.type == "select") {
        inputNode = field.html.querySelector("select");
      } else {
        inputNode = field.html.querySelector("input");
      }
      return inputNode.outerHTML;
    }
  );

  formWrapper.querySelector("form").prepend(node.childNodes[0]);
	fields.forEach(field=>field.parentElement.removeChild(field))
});
