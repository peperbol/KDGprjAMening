using UnityEngine;
using System.Collections;

public class SetAspectRatio : MonoBehaviour {
    public Material material;
    private RectTransform rectTransform;
    void Start() {
        rectTransform = GetComponent<RectTransform>();
    }
	void Update () {
        material.SetFloat("_AspectRatio", rectTransform.rect.size.x / rectTransform.rect.size.y);
	}
}
