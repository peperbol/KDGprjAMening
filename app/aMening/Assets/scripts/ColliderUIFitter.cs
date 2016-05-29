using UnityEngine;
using System.Collections;
using System.Linq;

/// <summary>
/// adjusts the collider to the UI element, for propper raycasting
/// </summary>
[RequireComponent(typeof(BoxCollider), typeof(RectTransform))]
public class ColliderUIFitter : MonoBehaviour {

    RectTransform rectTransform;
    BoxCollider boxCollider;
    public bool updateValues = false;
    public float yOffset = 0;
    public float yMultipier = 0;

    void Start ()
    {
        rectTransform = GetComponent<RectTransform>();
        boxCollider = GetComponent<BoxCollider>();
        if (!updateValues)
        {
            updateValues = true;
            Update();
            updateValues = false;
        }
    }
	
	// Update is called once per frame
	void Update () {
        if (updateValues)
        {
            //calculate the corners for the element and take the minimum and maximum of those
            Vector3[] corners = new Vector3[4];
            rectTransform.GetWorldCorners(corners);
            boxCollider.size = new Vector3(corners.Max(e => e.x) - corners.Min(e => e.x), corners.Max(e => e.y) - corners.Min(e => e.y), 1);
            boxCollider.center = new Vector3(0, boxCollider.size.y / 2 * ((1-rectTransform.pivot.y)*2-1) +  yOffset, 0);
        }
    }
}
